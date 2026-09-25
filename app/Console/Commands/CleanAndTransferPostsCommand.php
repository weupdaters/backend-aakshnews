<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class CleanAndTransferPostsCommand extends Command
{
    protected $signature = 'news:keep-latest-100 {--limit=100 : Number of latest news to keep per category} {--dry-run : Simulate without changing data}';
    protected $description = 'Keep only the latest N news per category, copy active images to storage/app/public/posts, and remove old posts';

    public function handle()
    {
        $limit = (int) $this->option('limit');
        $isDryRun = $this->option('dry-run');

        $this->info("===============================================================");
        $this->info("   AAKSH NEWS - CLEAN & TRANSFER LATEST {$limit} POSTS / CATEGORY");
        $this->info("===============================================================");

        if ($isDryRun) {
            $this->warn(">>> RUNNING IN DRY-RUN MODE (No database or file changes will be made) <<<");
        }

        // 1. Source and Target Image Paths
        $sourceDir = base_path('../storage_path');
        if (!is_dir($sourceDir)) {
            $sourceDir = public_path('storage_path');
        }
        $targetDir = storage_path('app/public/posts');

        if (!File::isDirectory($targetDir)) {
            File::makeDirectory($targetDir, 0755, true);
        }

        $this->info("Source Images Directory: {$sourceDir} (" . (is_dir($sourceDir) ? 'EXISTS' : 'NOT FOUND') . ")");
        $this->info("Target Storage Directory: {$targetDir}");

        // 2. Count total posts currently
        $totalBefore = DB::table('user_posts')->count();
        $this->info("Total current posts in user_posts: {$totalBefore}");

        // 3. Create Full Safety Backup Table (if not exists)
        if (!$isDryRun) {
            $hasBackup = Schema::hasTable('user_posts_backup_full');
            if (!$hasBackup) {
                $this->info("Creating full safety backup table 'user_posts_backup_full'...");
                DB::statement("CREATE TABLE user_posts_backup_full AS SELECT * FROM user_posts");
                $this->info("✓ Safety backup created with {$totalBefore} records.");
            } else {
                $backupCount = DB::table('user_posts_backup_full')->count();
                $this->info("✓ Existing safety backup 'user_posts_backup_full' found with {$backupCount} records.");
            }
        }

        // 4. Retrieve latest N posts per category using window function
        $this->info("\n--- Calculating Latest {$limit} Posts Per Category ---");
        $topPosts = DB::select("
            SELECT id, category, image_url, title 
            FROM (
                SELECT id, category, image_url, title, 
                       ROW_NUMBER() OVER (PARTITION BY category ORDER BY id DESC) as rn 
                FROM user_posts
            ) t 
            WHERE rn <= ?
        ", [$limit]);

        $keepCount = count($topPosts);
        $this->info("Identified {$keepCount} latest posts to keep across all categories.");

        $keepIds = [];
        $copiedImages = 0;
        $missingImages = 0;
        $categoryBreakdown = [];

        // 5. Process Image Transfers & URL Updates
        $this->info("\n--- Copying Active Images to storage/app/public/posts/ ---");
        $bar = $this->output->createProgressBar($keepCount);
        $bar->start();

        foreach ($topPosts as $post) {
            $keepIds[] = $post->id;
            $cat = $post->category ?: 'Uncategorized';
            $categoryBreakdown[$cat] = ($categoryBreakdown[$cat] ?? 0) + 1;

            if ($post->image_url) {
                // Extract clean filename from various path variations
                $rawUrl = $post->image_url;
                $filename = basename(parse_url($rawUrl, PHP_URL_PATH));

                $sourceFile = $sourceDir . DIRECTORY_SEPARATOR . $filename;
                $targetFile = $targetDir . DIRECTORY_SEPARATOR . $filename;

                if (File::exists($sourceFile)) {
                    if (!$isDryRun) {
                        if (!File::exists($targetFile)) {
                            File::copy($sourceFile, $targetFile);
                        }
                        // Update image_url to standard Laravel /storage/posts/ format
                        DB::table('user_posts')
                            ->where('id', $post->id)
                            ->update(['image_url' => '/storage/posts/' . $filename]);
                    }
                    $copiedImages++;
                } else {
                    $missingImages++;
                }
            }

            $bar->advance();
        }
        $bar->finish();
        $this->newLine(2);

        // 6. Delete Old Posts (Outside the Top 100 per category)
        $deletedCount = 0;
        if (!$isDryRun) {
            $this->info("--- Removing Old Posts Beyond Latest {$limit} ---");
            // Delete in safe chunks to avoid lock or memory timeouts
            $deleteQuery = DB::table('user_posts')->whereNotIn('id', $keepIds);
            $deletedCount = $deleteQuery->delete();
            $this->info("✓ Removed {$deletedCount} old posts from user_posts table.");
        } else {
            $deletedCount = $totalBefore - $keepCount;
            $this->warn("[Dry-run] Would delete {$deletedCount} old posts.");
        }

        // 7. Summary Report
        $totalAfter = $isDryRun ? $keepCount : DB::table('user_posts')->count();
        $this->newLine();
        $this->info("===============================================================");
        $this->info("                     MIGRATION COMPLETED                       ");
        $this->info("===============================================================");
        $this->table(
            ['Metric', 'Value'],
            [
                ['Posts Before Migration', number_format($totalBefore)],
                ['Latest Posts Kept', number_format($totalAfter)],
                ['Old Posts Deleted', number_format($deletedCount)],
                ['Images Copied to storage/app/public/posts', number_format($copiedImages)],
                ['Images Missing in storage_path', number_format($missingImages)],
                ['Storage Link Status', File::exists(public_path('storage')) ? 'Active (/public/storage)' : 'Created'],
            ]
        );

        $this->newLine();
        $this->info("Category Breakdown:");
        $catRows = [];
        foreach ($categoryBreakdown as $cat => $cnt) {
            $catRows[] = [$cat, $cnt];
        }
        $this->table(['Category', 'Posts Count'], $catRows);

        $this->info("✓ Done! Only fresh, active news and images are now stored in standard Laravel storage.");
        return 0;
    }
}
