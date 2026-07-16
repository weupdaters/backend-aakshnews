<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$sqlitePath = __DIR__ . '/database/database.sqlite';
if (!file_exists($sqlitePath)) {
    echo "SQLite database file not found at: {$sqlitePath}\n";
    exit;
}

try {
    // Connect to SQLite
    $sqlite = new PDO('sqlite:' . $sqlitePath);
    $sqlite->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Connect to MySQL using credentials from Laravel config
    $mysqlHost = config('database.connections.mysql.host');
    $mysqlPort = config('database.connections.mysql.port');
    $mysqlDb = config('database.connections.mysql.database');
    $mysqlUser = config('database.connections.mysql.username');
    $mysqlPass = config('database.connections.mysql.password');
    
    echo "Connecting to MySQL ({$mysqlDb} on {$mysqlHost}:{$mysqlPort})...\n";
    $mysql = new PDO("mysql:host={$mysqlHost};port={$mysqlPort};dbname={$mysqlDb}", $mysqlUser, $mysqlPass);
    $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Tables to transfer in order of foreign key dependencies
    $tables = ['users', 'categories', 'advertisements', 'breaking_news', 'photo_galleries', 'instagram_videos', 'user_posts'];

    foreach ($tables as $table) {
        echo "Transferring table: {$table}...\n";
        
        // Clear MySQL table
        $mysql->exec("SET FOREIGN_KEY_CHECKS = 0;");
        $mysql->exec("TRUNCATE TABLE `{$table}`");
        $mysql->exec("SET FOREIGN_KEY_CHECKS = 1;");
        
        // Fetch from SQLite
        $select = $sqlite->query("SELECT * FROM `{$table}`");
        $rows = $select->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($rows) === 0) {
            echo "No rows found in SQLite for `{$table}`. Skipped.\n";
            continue;
        }
        
        // Insert into MySQL
        $columns = array_keys($rows[0]);
        $colList = implode('`, `', $columns);
        $placeholders = implode(', ', array_map(fn($col) => ":{$col}", $columns));
        
        $insertQuery = "INSERT INTO `{$table}` (`{$colList}`) VALUES ({$placeholders})";
        $stmt = $mysql->prepare($insertQuery);
        
        foreach ($rows as $row) {
            $stmt->execute($row);
        }
        
        echo "Successfully transferred " . count($rows) . " rows for `{$table}`.\n";
    }

    echo "Updating user credentials in MySQL...\n";
    // 1. Update user ID 1 (originally admin@gmail.com)
    $user1 = \App\Models\User::find(1);
    if ($user1) {
        $user1->email = 'weupdaters@gmail.com';
        $user1->password = \Illuminate\Support\Facades\Hash::make('weupdaters@123');
        $user1->save();
        echo "Updated User 1 to email: weupdaters@gmail.com and password: weupdaters@123\n";
    }

    // 2. Update user ID 2 (originally admin@newsportal.in)
    $user2 = \App\Models\User::find(2);
    if ($user2) {
        $user2->password = \Illuminate\Support\Facades\Hash::make('weupdaters@123');
        $user2->save();
        echo "Updated User 2 password to: weupdaters@123\n";
    }

    echo "Ensuring all posts are marked as admin posts and published...\n";
    \App\Models\UserPost::query()->update([
        'is_admin_post' => true,
        'status' => 'published'
    ]);
    echo "All posts successfully marked as admin posts and published.\n";

    echo "Database transfer from SQLite to MySQL completed successfully!\n";

} catch (Exception $e) {
    echo "Error during database transfer: " . $e->getMessage() . "\n";
}





