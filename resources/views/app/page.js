"use client";

import { useState, useEffect, useRef } from 'react';

// --- MOCK DATASETS ---
const breakingNews = [
    "भारत ने T20 विश्व कप 2024 में पाकिस्तान को हराया",
    "मुंबई में भारी बारिश से जनजीवन प्रभावित, मौसम विभाग का रेड अलर्ट जारी",
    "शेयर बाजार में बड़ी गिरावट, सेंसेक्स 800 अंक नीचे गिरा",
    "सोने की कीमतों में भारी उछाल, रिकॉर्ड स्तर पर पहुंचे दाम"
];

const heroMain = {
    title: "नई दिल्ली में गर्मी ने तोड़ सारे रिकॉर्ड, तापमान 45 डिग्री के पार",
    category: "देश",
    description: "दिल्ली-एनसीआर में भीषण गर्मी का कहर जारी, लोगों को राहत की उम्मीद अगले सप्ताह है। मौसम विभाग ने कई इलाकों के लिए ऑरेंज व रेड अलर्ट जारी किया है।",
    time: "2 घंटे पहले",
    views: "12K व्यूज",
    image: "/images/hero_india_gate.png"
};

const heroMiddleStack = [
    {
        title: "प्रधानमंत्री मोदी का तीसरी बार शपथ ग्रहण समारोह आज",
        category: "राजनीति",
        time: "1 घंटे पहले",
        image: "/images/modi_oath.png"
    },
    {
        title: "भारत ने पाकिस्तान को 6 विकेट से हराया",
        category: "खेल",
        time: "3 घंटे पहले",
        image: "/images/cricket_win.png"
    },
    {
        title: "iPhone 16 सीरीज़ इस दिन होगी लॉन्च",
        category: "टेक्नोलॉजी",
        time: "5 घंटे पहले",
        image: "/images/iphone16_launch.png"
    }
];

const trendingNews = [
    { id: 1, title: "भारत ने T20 विश्व कप जीता", time: "2 घंटे पहले" },
    { id: 2, title: "मुंबई में भारी बारिश", time: "3 घंटे पहले" },
    { id: 3, title: "शेयर बाजार में गिरावट", time: "4 घंटे पहले" },
    { id: 4, title: "सोने की कीमतों में उछाल", time: "5 घंटे पहले" },
    { id: 5, title: "IPL 2024 का फाइनल आज", time: "6 घंटे पहले" }
];

const mostRead = [
    { id: 1, title: "पुरानी पेंशन योजना पर सरकार का बड़ा फैसला", views: "125K व्यूज" },
    { id: 2, title: "NEET परीक्षा रद्द करने की मांग तेज", views: "98K व्यूज" },
    { id: 3, title: "मानसून इस दिन देगा दस्तक", views: "81K व्यूज" },
    { id: 4, title: "पेट्रोल-डीजल के नए दाम जारी", views: "76K व्यूज" },
    { id: 5, title: "रेलवे ने शुरू की नई सुपरफास्ट ट्रेन", views: "65K व्यूज" }
];

const latestNews = [
    {
        title: "महाराष्ट्र के कई जिलों में भारी बारिश का अलर्ट",
        category: "राज्य",
        time: "10 मिनट पहले",
        image: "/images/rain_traffic.png"
    },
    {
        title: "शेयर बाजार में भारी गिरावट, निवेशकों को नुकसान",
        category: "बिजनेस",
        time: "25 मिनट पहले",
        image: "/images/stock_market.png"
    },
    {
        title: "ISRO की नई उपलब्धि, सफल हुआ PSLV मिशन",
        category: "विज्ञान",
        time: "45 मिनट पहले",
        image: "/images/isro_rocket.png"
    },
    {
        title: "सलमान खान की फिल्म 'सिकंदर' की रिलीज डेट तय",
        category: "मनोरंजन",
        time: "1 घंटे पहले",
        image: "/images/salman_khan.png"
    }
];

const videoNews = [
    {
        title: "दिल्ली में बारिश से जलभराव",
        time: "1 घंटे पहले",
        views: "12K व्यूज",
        duration: "02:40",
        image: "/images/video_delhi_rain.png",
        embed_url: "https://www.youtube.com/embed/5K1yN9tG4C0?enablejsapi=1",
        url: "https://www.youtube.com/shorts/5K1yN9tG4C0",
        category: "दिल्ली"
    },
    {
        title: "भारत की शानदार जीत",
        time: "2 घंटे पहले",
        views: "18K व्यूज",
        duration: "03:10",
        image: "/images/video_cricket.png",
        embed_url: "https://www.youtube.com/embed/gU9c13rWwL8?enablejsapi=1",
        url: "https://www.youtube.com/shorts/gU9c13rWwL8",
        category: "खेल"
    },
    {
        title: "राहुल गांधी का बड़ा बयान",
        time: "3 घंटे पहले",
        views: "8K व्यूज",
        duration: "01:50",
        image: "/images/video_rahul.png",
        embed_url: "https://www.youtube.com/embed/c0t36i2q_g0?enablejsapi=1",
        url: "https://www.youtube.com/shorts/c0t36i2q_g0",
        category: "राजनीति"
    },
    {
        title: "नई इलेक्ट्रिक कार लॉन्च",
        time: "4 घंटे पहले",
        views: "7K व्यूज",
        duration: "02:30",
        image: "/images/video_electric_car.png",
        embed_url: "https://www.youtube.com/embed/kHrn-rS2b4c?enablejsapi=1",
        url: "https://www.youtube.com/shorts/kHrn-rS2b4c",
        category: "टेक्नोलॉजी"
    },
    {
        title: "अंतरिक्ष में भारत का कमाल",
        time: "5 घंटे पहले",
        views: "11K व्यूज",
        duration: "02:20",
        image: "/images/video_space.png",
        embed_url: "https://www.youtube.com/embed/l5921-2Yd2s?enablejsapi=1",
        url: "https://www.youtube.com/shorts/l5921-2Yd2s",
        category: "विज्ञान"
    }
];

const categoriesNews = [
    {
        name: "राजनीति",
        icon: "grid",
        class: "politics",
        image: "/images/parliament.png",
        items: [
            "लोकसभा चुनाव के नतीजे",
            "विपक्ष का हंगामा जारी",
            "संविधान संशोधन पर चर्चा"
        ]
    },
    {
        name: "खेल",
        icon: "activity",
        class: "sports",
        image: "/images/cricket_sports.png",
        items: [
            "T20 विश्व कप 2024",
            "IPL 2024 का आयोजन",
            "विराट कोहली का रिकॉर्ड"
        ]
    },
    {
        name: "बिजनेस",
        icon: "briefcase",
        class: "business",
        image: "/images/stock_business.png",
        items: [
            "बाजार में आई गिरावट",
            "RBI का नया फैसला",
            "सोने-चांदी के भाव"
        ]
    },
    {
        name: "टेक्नोलॉजी",
        icon: "cpu",
        class: "technology",
        image: "/images/ai_technology.png",
        items: [
            "AI का भविष्य क्या है?",
            "WhatsApp का नया फीचर",
            "लॉन्च हुआ नया स्मार्टफोन"
        ]
    },
    {
        name: "दुनिया",
        icon: "globe",
        class: "world",
        image: "/images/world_leaders_category.png",
        items: [
            "अमेरिका के नए राष्ट्रपति",
            "इजरायल-हमास युद्ध",
            "चीन की नई रणनीति"
        ]
    }
];

const photoGallery = [
    { name: "केदारनाथ धाम", image: "/images/photo_kedarnath.png" },
    { name: "गोवा बीच", image: "/images/photo_goa.png" },
    { name: "लद्दाख यात्रा", image: "/images/photo_ladakh.png" },
    { name: "वाराणसी घाट", image: "/images/photo_varanasi.png" },
    { name: "जयपुर सिटी पैलेस", image: "/images/photo_jaipur.png" },
    { name: "ताज महल", image: "/images/photo_tajmahal.png" },
    { name: "हम्पी मंदिर", image: "/images/photo_hampi.png" }
];

export default function Home() {
    // --- STATE MANAGEMENT ---
    const [fontSize, setFontSize] = useState(16);
    const [theme, setTheme] = useState('dark');
    const [breakingIndex, setBreakingIndex] = useState(0);
    const [sidebarOpen, setSidebarOpen] = useState(false);
    const [email, setEmail] = useState('');
    const [modalOpen, setModalOpen] = useState(false);
    const [modalMsg, setModalMsg] = useState('');
    const [bookmarks, setBookmarks] = useState({});
    const [toastMsg, setToastMsg] = useState('');
    const [toastActive, setToastActive] = useState(false);
    const [dateString, setDateString] = useState('');

    const [reelsOpen, setReelsOpen] = useState(false);
    const [reelsDataset, setReelsDataset] = useState([]);
    const [reelsActiveIndex, setReelsActiveIndex] = useState(0);
    const [reelsPlaying, setReelsPlaying] = useState(true);
    const [reelsMuted, setReelsMuted] = useState(false);
    const [reelsSpeed, setReelsSpeed] = useState(1);
    const [reelsCurrentTime, setReelsCurrentTime] = useState(0);
    const [reelsDuration, setReelsDuration] = useState(57);
    const [instagramVideos, setInstagramVideos] = useState([]);
    const [userPosts, setUserPosts] = useState([]);
    const [postForm, setPostForm] = useState({ title: '', content: '', category: 'ताजा खबर', author_name: '' });
    const [submittingPost, setSubmittingPost] = useState(false);
    const [postSubmitStatus, setPostSubmitStatus] = useState(null);

    const galleryRef = useRef(null);
    const reelsScrollRef = useRef(null);
    const iframeRefs = useRef([]);

    // Get current formatted Hindi date string
    useEffect(() => {
        const today = new Date();
        const days = ['रविवार', 'सोमवार', 'मंगलवार', 'बुधवार', 'गुरुवार', 'शुक्रवार', 'शनिवार'];
        const months = ['जनवरी', 'फरवरी', 'मार्च', 'अप्रैल', 'मई', 'जून', 'जुलाई', 'अगस्त', 'सितंबर', 'अक्टूबर', 'नवंबर', 'दिसंबर'];
        setDateString(`${days[today.getDay()]}, ${today.getDate()} ${months[today.getMonth()]} ${today.getFullYear()}`);
    }, []);

    // Load saved settings on mount
    useEffect(() => {
        const savedTheme = localStorage.getItem('theme') || 'dark';
        const savedFontSize = localStorage.getItem('baseFontSize');

        setTheme(savedTheme);
        if (savedTheme === 'dark') {
            document.body.classList.add('dark-theme');
        } else {
            document.body.classList.remove('dark-theme');
        }

        if (savedFontSize) {
            const size = parseInt(savedFontSize);
            setFontSize(size);
            document.documentElement.style.setProperty('--base-font-size', `${size}px`);
        }
    }, []);

    // Auto-advance breaking news slides
    useEffect(() => {
        const timer = setInterval(() => {
            setBreakingIndex(prev => (prev + 1) % breakingNews.length);
        }, 5000);
        
    // Render Feather Icons
    useEffect(() => {
        if (typeof window !== 'undefined' && window.feather) {
            window.feather.replace();
        }
    });

    return () => clearInterval(timer);
    }, []);

    // Fetch Instagram videos
    useEffect(() => {
        const fetchInsta = async () => {
            try {
                const res = await fetch('/api/instagram-videos');
                if (res.ok) {
                    const data = await res.json();
                    setInstagramVideos(data);
                }
            } catch (err) {
                console.error('Error fetching instagram videos:', err);
            }
        };
        fetchInsta();
    }, []);

    // Fetch User Posts
    useEffect(() => {
        const fetchPosts = async () => {
            try {
                const res = await fetch('/api/posts');
                if (res.ok) {
                    const data = await res.json();
                    setUserPosts(data);
                }
            } catch (err) {
                console.error('Error fetching user posts:', err);
            }
        };
        fetchPosts();
    }, []);

    const handlePostSubmit = async (e) => {
        e.preventDefault();
        setSubmittingPost(true);
        setPostSubmitStatus(null);
        try {
            const res = await fetch('/api/posts', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(postForm),
            });
            const data = await res.json();
            if (res.ok && data.success) {
                setPostSubmitStatus({
                    success: true,
                    message: data.message,
                    aiFeedback: typeof data.post.ai_feedback === 'string' ? JSON.parse(data.post.ai_feedback) : data.post.ai_feedback
                });
                setPostForm({ title: '', content: '', category: 'ताजा खबर', author_name: '' });
                // Refresh list
                const postsRes = await fetch('/api/posts');
                if (postsRes.ok) {
                    const postsData = await postsRes.json();
                    setUserPosts(postsData);
                }
            } else {
                setPostSubmitStatus({
                    success: false,
                    message: data.message || 'Error: Unable to submit post.',
                    aiFeedback: data.post ? (typeof data.post.ai_feedback === 'string' ? JSON.parse(data.post.ai_feedback) : data.post.ai_feedback) : null
                });
            }
        } catch (err) {
            console.error('Error submitting post:', err);
            setPostSubmitStatus({
                success: false,
                message: 'Unable to connect to the server.'
            });
        } finally {
            setSubmittingPost(false);
        }
    };

    // Helper to control YouTube Iframe API
    const controlYoutube = (idx, command, args = []) => {
        const iframe = iframeRefs.current[idx];
        if (iframe && iframe.contentWindow) {
            try {
                iframe.contentWindow.postMessage(
                    JSON.stringify({ event: 'command', func: command, args }),
                    '*'
                );
            } catch (e) {
                console.error('Iframe communication error:', e);
            }
        }
    };

    // Reels Timer
    useEffect(() => {
        let timer = null;
        if (reelsOpen && reelsPlaying) {
            timer = setInterval(() => {
                setReelsCurrentTime(prev => {
                    if (prev >= reelsDuration) {
                        setReelsPlaying(false);
                        return reelsDuration;
                    }
                    return prev + 1;
                });
            }, 1000);
        }
        
    // Render Feather Icons
    useEffect(() => {
        if (typeof window !== 'undefined' && window.feather) {
            window.feather.replace();
        }
    });

    return () => {
            if (timer) clearInterval(timer);
        };
    }, [reelsOpen, reelsPlaying, reelsDuration]);

    // Active reel changes side effects
    useEffect(() => {
        if (!reelsOpen || reelsDataset.length === 0) return;

        const video = reelsDataset[reelsActiveIndex];
        if (video) {
            let durSecs = 57;
            const durStr = video.duration || '00:57';
            const parts = durStr.split(':');
            if (parts.length === 2) {
                durSecs = parseInt(parts[0], 10) * 60 + parseInt(parts[1], 10);
            }
            setReelsDuration(durSecs);
            setReelsCurrentTime(0);
            setReelsPlaying(true);
            setReelsSpeed(1);

            // Control playback
            reelsDataset.forEach((_, i) => {
                if (i === reelsActiveIndex) {
                    setTimeout(() => {
                        controlYoutube(i, 'playVideo');
                        controlYoutube(i, reelsMuted ? 'mute' : 'unMute');
                    }, 200);
                } else {
                    controlYoutube(i, 'pauseVideo');
                }
            });
        }
    }, [reelsActiveIndex, reelsDataset, reelsOpen]);

    // Scroll snapping
    useEffect(() => {
        if (reelsOpen && reelsScrollRef.current) {
            const container = reelsScrollRef.current;
            const slideHeight = container.clientHeight;
            container.scrollTo({
                top: reelsActiveIndex * slideHeight,
                behavior: 'smooth'
            });
        }
    }, [reelsActiveIndex, reelsOpen]);

    // Keyboard navigation
    useEffect(() => {
        const handleKeyDown = (e) => {
            if (!reelsOpen) return;
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                if (reelsActiveIndex < reelsDataset.length - 1) {
                    setReelsActiveIndex(prev => prev + 1);
                }
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                if (reelsActiveIndex > 0) {
                    setReelsActiveIndex(prev => prev - 1);
                }
            } else if (e.key === 'Escape') {
                closeReels();
            }
        };
        window.addEventListener('keydown', handleKeyDown);
        
    // Render Feather Icons
    useEffect(() => {
        if (typeof window !== 'undefined' && window.feather) {
            window.feather.replace();
        }
    });

    return () => window.removeEventListener('keydown', handleKeyDown);
    }, [reelsOpen, reelsActiveIndex, reelsDataset]);

    const handleReelsScroll = () => {
        if (!reelsScrollRef.current) return;
        const container = reelsScrollRef.current;
        const scrollPosition = container.scrollTop;
        const slideHeight = container.clientHeight;
        if (slideHeight <= 0) return;
        const index = Math.round(scrollPosition / slideHeight);
        if (index !== reelsActiveIndex && index >= 0 && index < reelsDataset.length) {
            setReelsActiveIndex(index);
        }
    };

    const toggleReelsSpeed = () => {
        let nextSpeed = 1;
        if (reelsSpeed === 1) nextSpeed = 1.5;
        else if (reelsSpeed === 1.5) nextSpeed = 2;
        else if (reelsSpeed === 2) nextSpeed = 0.5;
        else nextSpeed = 1;

        setReelsSpeed(nextSpeed);
        controlYoutube(reelsActiveIndex, 'setPlaybackRate', [nextSpeed]);
    };

    const toggleReelsPlayPause = () => {
        const nextPlaying = !reelsPlaying;
        setReelsPlaying(nextPlaying);
        controlYoutube(reelsActiveIndex, nextPlaying ? 'playVideo' : 'pauseVideo');
    };

    const toggleReelsMute = () => {
        const nextMuted = !reelsMuted;
        setReelsMuted(nextMuted);
        controlYoutube(reelsActiveIndex, nextMuted ? 'mute' : 'unMute');
    };

    const skipReelsTime = (seconds) => {
        const nextTime = Math.max(0, Math.min(reelsDuration, reelsCurrentTime + seconds));
        setReelsCurrentTime(nextTime);
        controlYoutube(reelsActiveIndex, 'seekTo', [nextTime, true]);
    };

    const seekReelsTime = (val) => {
        setReelsCurrentTime(val);
        controlYoutube(reelsActiveIndex, 'seekTo', [val, true]);
    };

    const closeReels = () => {
        reelsDataset.forEach((_, i) => {
            controlYoutube(i, 'pauseVideo');
        });
        setReelsOpen(false);
        setReelsPlaying(false);
    };

    const copyReelsLink = () => {
        const video = reelsDataset[reelsActiveIndex];
        if (video && video.url) {
            navigator.clipboard.writeText(video.url).then(() => {
                triggerToast('लिंक कॉपी कर लिया गया है!');
            });
        }
    };

    // --- ACTIONS ---
    const changeFontSize = (diff) => {
        let newSize = fontSize + diff;
        if (diff === 0) newSize = 16;
        if (newSize >= 12 && newSize <= 22) {
            setFontSize(newSize);
            document.documentElement.style.setProperty('--base-font-size', `${newSize}px`);
            localStorage.setItem('baseFontSize', newSize);
        }
    };

    const toggleTheme = () => {
        const newTheme = theme === 'light' ? 'dark' : 'light';
        setTheme(newTheme);
        localStorage.setItem('theme', newTheme);
        if (newTheme === 'dark') {
            document.body.classList.add('dark-theme');
        } else {
            document.body.classList.remove('dark-theme');
        }
    };

    const triggerToast = (msg) => {
        setToastMsg(msg);
        setToastActive(true);
        setTimeout(() => {
            setToastActive(false);
        }, 3000);
    };

    const handleCardClick = (title) => {
        let text = title;
        if (text.length > 40) {
            text = text.substring(0, 37) + '...';
        }
        triggerToast(`"${text}" - विस्तार से पढ़ने के लिए लॉगिन करें!`);
    };

    const toggleBookmark = (id, e) => {
        e.stopPropagation();
        setBookmarks(prev => {
            const next = { ...prev };
            const newState = !next[id];
            next[id] = newState;

            if (newState) {
                triggerToast('समाचार बुकमार्क कर लिया गया है!');
            } else {
                triggerToast('बुकमार्क हटा दिया गया!');
            }
            return next;
        });
    };

    const scrollGallery = (direction) => {
        if (galleryRef.current) {
            galleryRef.current.scrollBy({
                left: direction * 200,
                behavior: 'smooth'
            });
        }
    };

    const triggerPushNotification = () => {
        if (typeof window !== 'undefined' && 'Notification' in window) {
            Notification.requestPermission().then((permission) => {
                if (permission === 'granted') {
                    new Notification("Aakash News 24", {
                        body: "Aakash News 24 में आपका स्वागत है! आपको ताज़ा ख़बरें मिलती रहेंगी।",
                        icon: "/images/logo.png"
                    });
                }
            });
        }
    };

    const handleSubscribe = async (e) => {
        e.preventDefault();
        if (!email.trim()) return;

        try {
            const response = await fetch('/api/subscribe', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email })
            });
            const result = await response.json();
            if (response.ok && result.success) {
                setModalMsg(result.message);
                setModalOpen(true);
                setEmail('');
                triggerPushNotification();
            } else {
                alert(result.message || 'त्रुटि: कृपया पुनः प्रयास करें।');
            }
        } catch (err) {
            console.error(err);
            alert('सर्वर से कनेक्ट करने में असमर्थ।');
        }
    };

    
    // Render Feather Icons
    useEffect(() => {
        if (typeof window !== 'undefined' && window.feather) {
            window.feather.replace();
        }
    });

    return (
        <>
            {/* 1. Top Bar */}
            <div className="top-bar">
                <div className="container top-bar-content">
                    <div className="top-bar-left">
                        <span><i data-feather="calendar"></i> {dateString}</span>
                        <span className="weather">
                            <i data-feather="sun" style={{ color: '#f6ad55' }}></i> 32°C नई दिल्ली
                        </span>
                    </div>

                    <div className="top-bar-ticker">
                        <span className="ticker-badge">Breaking</span>
                        <div className="ticker-text-wrapper">
                            <span className="ticker-text">
                                {breakingNews.join(" \u00a0\u00a0•\u00a0\u00a0 ")}
                            </span>
                        </div>
                    </div>

                    <div className="top-bar-right">
                        <div className="font-controls">
                            <button className="font-btn" onClick={() => changeFontSize(-2)} title="फ़ॉन्ट छोटा करें">A-</button>
                            <button className="font-btn" onClick={() => changeFontSize(0)} title="फ़ॉन्ट रीसेट करें">A</button>
                            <button className="font-btn" onClick={() => changeFontSize(2)} title="फ़ॉन्ट बड़ा करें">A+</button>
                        </div>
                        <button className="theme-toggle" onClick={toggleTheme} title="थीम बदलें">
                            <i className={theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon'}></i>
                        </button>
                        <a href="#" className="login-link"><i data-feather="user"></i> लॉगिन / साइनअप</a>
                    </div>
                </div>
            </div>

            {/* 2. Main Header */}
            <header className="main-header">
                <div className="container header-grid">
                    <div className="logo-area">
                        <a href="/" className="logo" style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
                            <img src="/images/logo.png" alt="Aakash News 24" style={{ height: '48px', width: '48px', borderRadius: '50%', objectFit: 'cover' }} />
                            <div style={{ display: 'flex', flexDirection: 'column', lineHeight: '1.1' }}>
                                <div style={{ display: 'flex', alignItems: 'center' }}>
                                    <span style={{ color: 'var(--text-main)', fontWeight: 900, fontSize: '1.4rem', letterSpacing: '0.5px' }}>AAKASH</span>
                                    <span style={{ color: '#e53e3e', fontWeight: 900, fontSize: '1.4rem', letterSpacing: '0.5px', marginLeft: '6px' }}>NEWS 24</span>
                                </div>
                                <span className="tagline" style={{ fontSize: '0.72rem', fontWeight: 700, color: 'var(--text-muted)', letterSpacing: '0.5px', marginTop: '2px' }}>Always Ahead</span>
                            </div>
                        </a>
                    </div>

                    <div className="search-bar">
                        <input type="text" className="search-input" placeholder="खबर खोजें..." id="search-input" />
                        <i data-feather="search" className="search-icon" id="search-btn"></i>
                    </div>

                    <div className="header-actions">
                        <div className="header-action-item">
                            <i data-feather="file-text"></i>
                            <span>ई-पेपर</span>
                        </div>
                        <div className="header-action-item">
                            <i data-feather="video"></i>
                            <span>वीडियो</span>
                        </div>
                        <div className="header-action-item">
                            <i data-feather="settings"></i>
                            <span>सेटिंग्स</span>
                        </div>
                        <button className="bookmark-btn" onClick={() => {
                            document.querySelector('.newsletter-bar')?.scrollIntoView({ behavior: 'smooth' });
                            triggerPushNotification();
                        }}>
                            <i data-feather="bell"></i>
                            <span>सब्सक्राइब</span>
                        </button>
                    </div>
                </div>
            </header>

            {/* 3. Navigation Bar */}
            <nav className="nav-bar">
                <div className="container nav-container">
                    <button className="hamburger-btn" onClick={() => setSidebarOpen(true)} title="मेन्यू खोलें">
                        <i data-feather="menu"></i>
                    </button>
                    <ul className="nav-links">
                        <li className="nav-item active"><a href="/">होम</a></li>
                        <li className="nav-item"><a href="#">देश</a></li>
                        <li className="nav-item"><a href="#">राज्य</a></li>
                        <li className="nav-item"><a href="#">राजनीति</a></li>
                        <li className="nav-item"><a href="#">खेल</a></li>
                        <li className="nav-item"><a href="#">बिजनेस</a></li>
                        <li className="nav-item"><a href="#">टेक्नोलॉजी</a></li>
                        <li className="nav-item"><a href="#">मनोरंजन</a></li>
                        <li className="nav-item"><a href="#">लाइफस्टाइल</a></li>
                        <li className="nav-item"><a href="#">एजुकेशन</a></li>
                        <li className="nav-item"><a href="#">दुनिया</a></li>
                        <li className="nav-item dropdown">
                            <a href="#">और <i data-feather="chevron-down" style={{ fontSize: '0.8rem', marginLeft: '2px' }}></i></a>
                            <ul className="dropdown-menu">
                                <li><a href="#">करियर</a></li>
                                <li><a href="#">धर्म / धर्म-कर्म</a></li>
                                <li><a href="#">फोटो गैलरी</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            {/* Mobile Sidebar Drawer */}
            <div className={`mobile-sidebar ${sidebarOpen ? 'open' : ''}`}>
                <div className="mobile-sidebar-header">
                    <a href="/" className="logo" style={{ display: 'flex', alignItems: 'center', gap: '8px' }}>
                        <img src="/images/logo.png" alt="Aakash News 24" style={{ height: '36px', width: '36px', borderRadius: '50%' }} />
                        <span style={{ color: 'var(--text-main)', fontWeight: 900, fontSize: '1.25rem' }}>AAKASH <span style={{ color: '#e53e3e' }}>NEWS 24</span></span>
                    </a>
                    <button className="mobile-sidebar-close" onClick={() => setSidebarOpen(false)}>&times;</button>
                </div>
                <ul className="mobile-nav-links">
                    <li className="active"><a href="/" onClick={() => setSidebarOpen(false)}>होम</a></li>
                    <li><a href="#" onClick={() => setSidebarOpen(false)}>देश</a></li>
                    <li><a href="#" onClick={() => setSidebarOpen(false)}>राज्य</a></li>
                    <li><a href="#" onClick={() => setSidebarOpen(false)}>राजनीति</a></li>
                    <li><a href="#" onClick={() => setSidebarOpen(false)}>खेल</a></li>
                    <li><a href="#" onClick={() => setSidebarOpen(false)}>बिजनेस</a></li>
                    <li><a href="#" onClick={() => setSidebarOpen(false)}>टेक्नोलॉजी</a></li>
                    <li><a href="#" onClick={() => setSidebarOpen(false)}>मनोरंजन</a></li>
                    <li><a href="#" onClick={() => setSidebarOpen(false)}>लाइफस्टाइल</a></li>
                    <li><a href="#" onClick={() => setSidebarOpen(false)}>एजुकेशन</a></li>
                    <li><a href="#" onClick={() => setSidebarOpen(false)}>दुनिया</a></li>
                    <li><a href="#" onClick={() => setSidebarOpen(false)}>फोटो गैलरी</a></li>
                </ul>
            </div>
            <div className={`sidebar-overlay ${sidebarOpen ? 'show' : ''}`} onClick={() => setSidebarOpen(false)}></div>

            {/* 4. Breaking News Sub-Ticker */}
            <div className="breaking-ticker-bar">
                <div className="container breaking-container">
                    <span className="breaking-label"><i data-feather="zap"></i> ब्रेकिंग न्यूज़</span>
                    <div className="breaking-slider-wrapper">
                        {breakingNews.map((news, idx) => (
                            <div
                                key={idx}
                                className={`breaking-slide ${idx === breakingIndex ? 'active' : ''}`}
                                onClick={() => handleCardClick(news)}
                            >
                                • {news}
                            </div>
                        ))}
                    </div>
                    <div className="breaking-nav-btns">
                        <button className="breaking-nav-btn" onClick={() => setBreakingIndex(prev => (prev - 1 + breakingNews.length) % breakingNews.length)}>
                            <i data-feather="chevron-left"></i>
                        </button>
                        <button className="breaking-nav-btn" onClick={() => setBreakingIndex(prev => (prev + 1) % breakingNews.length)}>
                            <i data-feather="chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            {/* Portal Main 3-Column Layout Wrapper */}
            <div className="portal-main-layout">

                {/* Left Sidebar Sticky Navigation Menu */}
                <aside className="portal-left-col">
                    <div className="vertical-nav-menu">
                        <ul className="vertical-nav-links">
                            <li className="active"><a href="/"><i data-feather="home"></i> <span>होम</span></a></li>
                            <li><a href="#"><i data-feather="flag"></i> <span>देश</span></a></li>
                            <li><a href="#"><i data-feather="map-pin"></i> <span>राज्य</span></a></li>
                            <li><a href="#"><i data-feather="grid"></i> <span>राजनीति</span></a></li>
                            <li><a href="#"><i data-feather="activity"></i> <span>खेल</span></a></li>
                            <li><a href="#"><i data-feather="briefcase"></i> <span>बिजनेस</span></a></li>
                            <li><a href="#"><i data-feather="cpu"></i> <span>टेक्नोलॉजी</span></a></li>
                            <li><a href="#"><i data-feather="film"></i> <span>मनोरंजन</span></a></li>
                            <li><a href="#"><i data-feather="heart"></i> <span>लाइफस्टाइल</span></a></li>
                            <li><a href="#"><i data-feather="book-open"></i> <span>एजुकेशन</span></a></li>
                            <li><a href="#"><i data-feather="globe"></i> <span>दुनिया</span></a></li>
                            <li><a href="#"><i data-feather="image"></i> <span>फोटो गैलरी</span></a></li>
                        </ul>
                    </div>
                </aside>

                {/* Middle Column: Scrollable Content Feed */}
                <div className="portal-middle-col">

                    {/* 5. Hero Section (Grid Layout) */}
                    <section className="hero-section hero-grid">

                        {/* Left Large Card */}
                        <div className="hero-large-card" onClick={() => handleCardClick(heroMain.title)}>
                            <div className="card-img-wrapper">
                                <img src={heroMain.image} alt={heroMain.title} loading="lazy" />
                            </div>
                            <div className="hero-large-content">
                                <span className="tag tag-देश">{heroMain.category}</span>
                                <h2 className="hero-large-title">{heroMain.title}</h2>
                                <p className="hero-large-desc">{heroMain.description}</p>
                                <div className="hero-card-footer">
                                    <div className="hero-card-meta">
                                        <span><i data-feather="clock"></i> {heroMain.time}</span>
                                        <span><i data-feather="eye"></i> {heroMain.views}</span>
                                    </div>
                                    <button
                                        className="bookmark-icon-btn"
                                        onClick={(e) => toggleBookmark('hero', e)}
                                    >
                                        <i className={bookmarks['hero'] ? 'fas fa-bookmark' : 'far fa-bookmark'} style={{ color: bookmarks['hero'] ? 'var(--primary-color)' : '' }}></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {/* Middle Stack */}
                        <div className="hero-middle-stack">
                            {heroMiddleStack.map((card, idx) => (
                                <div
                                    key={idx}
                                    className="middle-stack-card"
                                    onClick={() => handleCardClick(card.title)}
                                >
                                    <div className="middle-stack-img">
                                        <img src={card.image} alt={card.title} loading="lazy" />
                                    </div>
                                    <div className="middle-stack-content">
                                        <span className={`tag tag-${card.category}`}>{card.category}</span>
                                        <h3 className="middle-stack-title">{card.title}</h3>
                                        <span className="middle-stack-time"><i data-feather="clock"></i> {card.time}</span>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </section>

                    {/* 6. Section "ताजा खबरें" */}
                    <section className="section-wrapper">
                        <div className="section-title-bar">
                            <h3 className="section-title">ताजा खबरें</h3>
                            <a href="#" className="section-view-all">सभी देखें <i data-feather="chevron-right" style={{ fontSize: '0.75rem' }}></i></a>
                        </div>

                        <div className="latest-grid">
                            {latestNews.map((news, idx) => (
                                <div
                                    key={idx}
                                    className="news-card"
                                    onClick={() => handleCardClick(news.title)}
                                >
                                    <div className="news-card-img">
                                        <img src={news.image} alt={news.title} loading="lazy" />
                                        <span className={`tag tag-${news.category}`}>{news.category}</span>
                                    </div>
                                    <div className="news-card-body">
                                        <h4 className="news-card-title">{news.title}</h4>
                                        <div className="news-card-footer">
                                            <span><i data-feather="clock"></i> {news.time}</span>
                                            <i
                                                className={bookmarks[`latest-${idx}`] ? 'fas fa-bookmark' : 'far fa-bookmark'}
                                                style={{ cursor: 'pointer', color: bookmarks[`latest-${idx}`] ? 'var(--primary-color)' : '' }}
                                                onClick={(e) => toggleBookmark(`latest-${idx}`, e)}
                                            ></i>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </section>

                    {/* 7. Section "वीडियो न्यूज़" */}
                    <section className="section-wrapper">
                        <div className="section-title-bar">
                            <h3 className="section-title">वीडियो न्यूज़</h3>
                            <a href="#" className="section-view-all">सभी देखें <i data-feather="chevron-right" style={{ fontSize: '0.75rem' }}></i></a>
                        </div>

                        <div className="video-grid">
                            {videoNews.map((video, idx) => (
                                <div
                                    key={idx}
                                    className="video-card"
                                    onClick={() => {
                                        setReelsDataset(videoNews);
                                        setReelsActiveIndex(idx);
                                        setReelsOpen(true);
                                    }}
                                    style={{ cursor: 'pointer' }}
                                >
                                    <div className="video-card-thumb">
                                        <img src={video.image} alt={video.title} loading="lazy" />
                                        <div className="video-overlay">
                                            <div className="play-icon">
                                                <i data-feather="play"></i>
                                            </div>
                                        </div>
                                        <span className="video-duration">{video.duration}</span>
                                    </div>
                                    <h4 className="video-title">{video.title}</h4>
                                    <div className="video-meta">
                                        <span><i data-feather="clock"></i> {video.time}</span>
                                        <span><i data-feather="eye"></i> {video.views}</span>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </section>

                    {/* Instagram Videos Section */}
                    <section className="section-wrapper">
                        <div className="section-title-bar">
                            <div style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
                                <i data-feather="instagram" style={{ fontSize: '1.8rem', color: '#e1306c' }}></i>
                                <h3 className="section-title" style={{ marginBottom: 0 }}>इंस्टाग्राम वीडियो & रील्स</h3>
                            </div>
                        </div>

                        <div className="instagram-grid" id="instagram-videos-container">
                            {instagramVideos.length > 0 ? (
                                instagramVideos.map((video, idx) => (
                                    <div
                                        key={idx}
                                        className="instagram-card"
                                        onClick={() => {
                                            setReelsDataset(instagramVideos);
                                            setReelsActiveIndex(idx);
                                            setReelsOpen(true);
                                        }}
                                        style={{ background: 'var(--bg-card)', borderRadius: '12px', boxShadow: 'var(--box-shadow)', overflow: 'hidden', display: 'flex', flexDirection: 'column', transition: 'transform 0.3s ease, box-shadow 0.3s ease', cursor: 'pointer' }}
                                    >
                                        <div style={{ position: 'relative', width: '100%', paddingTop: '120%', background: '#000' }}>
                                            {/* Click interceptor overlay with play button */}
                                            <div className="instagram-card-overlay" style={{ position: 'absolute', top: 0, left: 0, width: '100%', height: '100%', zIndex: 10, display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                                                <div className="play-btn-overlay" style={{ width: '60px', height: '60px', borderRadius: '50%', background: 'rgba(225, 48, 108, 0.95)', display: 'flex', alignItems: 'center', justifyContent: 'center', color: '#fff', fontSize: '1.8rem', boxShadow: '0 8px 15px rgba(0,0,0,0.3)', opacity: 0, transition: 'transform 0.3s, opacity 0.3s' }}>
                                                    <i data-feather="play" style={{ marginLeft: '6px' }}></i>
                                                </div>
                                            </div>
                                            <iframe src={video.embed_url} style={{ position: 'absolute', top: 0, left: 0, width: '100%', height: '100%', border: 0 }} allowtransparency="true" allow="encrypted-media" scrolling="no"></iframe>
                                        </div>
                                        <div style={{ padding: '15px', flexGrow: 1, display: 'flex', flexDirection: 'column', justifyContent: 'space-between', position: 'relative' }}>
                                            <div>
                                                <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', gap: '10px' }}>
                                                    <h4 style={{ fontSize: '1.05rem', fontWeight: 700, marginBottom: '8px', color: 'var(--text-main)', flexGrow: 1, lineHeight: 1.4 }}>{video.title || 'इंस्टाग्राम वीडियो'}</h4>
                                                </div>
                                            </div>
                                            <span style={{ fontSize: '0.8rem', color: 'var(--text-muted)' }}><i data-feather="clock"></i> {video.created_at ? new Date(video.created_at).toLocaleDateString('hi-IN') : 'अभी-अभी'}</span>
                                        </div>
                                    </div>
                                ))
                            ) : (
                                <div id="no-instagram-videos" style={{ gridColumn: '1 / -1', textAlign: 'center', padding: '40px', background: 'var(--bg-card)', borderRadius: '12px', color: 'var(--text-muted)' }}>
                                    <i data-feather="instagram" style={{ fontSize: '3rem', color: '#ddd', marginBottom: '10px', display: 'block' }}></i>
                                    <span>अभी तक कोई इंस्टाग्राम वीडियो नहीं जोड़ा गया है।</span>
                                </div>
                            )}
                        </div>
                    </section>

                    {/* 8. Section "खबरें श्रेणी अनुसार" */}
                    <section className="section-wrapper">
                        <div className="section-title-bar">
                            <h3 className="section-title">खबरें श्रेणी अनुसार</h3>
                            <a href="#" className="section-view-all">सभी देखें <i data-feather="chevron-right" style={{ fontSize: '0.75rem' }}></i></a>
                        </div>

                        <div className="category-grid">
                            {categoriesNews.map((cat, idx) => (
                                <div key={idx} className={`category-card ${cat.class}`}>
                                    <div className="category-card-header">
                                        <div className="category-icon">
                                            <i className={`fas ${cat.icon}`}></i>
                                        </div>
                                        <span>{cat.name}</span>
                                    </div>
                                    <div className="category-card-img">
                                        <img src={cat.image} alt={cat.name} loading="lazy" />
                                    </div>
                                    <ul className="category-news-list">
                                        {cat.items.map((item, itemIdx) => (
                                            <li
                                                key={itemIdx}
                                                className="category-news-item"
                                                onClick={() => handleCardClick(item)}
                                            >
                                                <span className="category-bullet">{itemIdx + 1}</span>
                                                <span>{item}</span>
                                            </li>
                                        ))}
                                    </ul>
                                    <button className="panel-more-btn">और देखें</button>
                                </div>
                            ))}
                        </div>
                    </section>

                    {/* Reader's Corner - User Posts */}
                    <section className="section-wrapper" style={{ marginBottom: '35px' }}>
                        <div className="section-title-bar" style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', borderBottom: '2px solid var(--border-color)', paddingBottom: '8px' }}>
                            <h3 className="section-title" style={{ margin: 0, fontSize: '1.4rem', fontWeight: 800 }}>पाठक कोना - आपके विचार</h3>
                            <span style={{ fontSize: '0.82rem', color: 'var(--text-muted)', fontWeight: 500, display: 'flex', alignItems: 'center', gap: '5px' }}>
                                <i data-feather="users"></i> पाठकों की आवाज़
                            </span>
                        </div>

                        <div className="reader-corner-container" style={{ marginTop: '20px' }}>
                            {/* Form Column */}
                            <div className="post-form-card" style={{ background: 'var(--bg-card)', border: '1px solid var(--border-color)', borderRadius: '12px', padding: '24px', boxShadow: '0 4px 20px rgba(0,0,0,0.05)', display: 'flex', flexDirection: 'column', gap: '15px' }}>
                                <h4 style={{ fontSize: '1.15rem', fontWeight: 700, color: 'var(--text-main)', display: 'flex', alignItems: 'center', gap: '8px', borderBottom: '1px solid var(--border-color)', paddingBottom: '12px', margin: 0 }}>
                                    <i data-feather="edit-2" style={{ color: 'var(--primary-color)', fontSize: '1rem' }}></i>
                                    अपनी खबर/विचार साझा करें
                                </h4>

                                <form onSubmit={handlePostSubmit} style={{ display: 'flex', flexDirection: 'column', gap: '12px' }}>
                                    <div>
                                        <label style={{ display: 'block', fontSize: '0.82rem', fontWeight: 600, marginBottom: '6px', color: 'var(--text-main)' }}>आपका नाम</label>
                                        <input
                                            type="text"
                                            placeholder="अनाम (Anonymous) या अपना नाम लिखें"
                                            value={postForm.author_name}
                                            onChange={e => setPostForm({ ...postForm, author_name: e.target.value })}
                                            style={{ width: '100%', padding: '12px', borderRadius: '8px', border: '1px solid var(--border-color)', background: 'var(--bg-body)', color: 'var(--text-main)', fontSize: '0.9rem', transition: 'border-color 0.2s' }}
                                        />
                                    </div>

                                    <div>
                                        <label style={{ display: 'block', fontSize: '0.82rem', fontWeight: 600, marginBottom: '6px', color: 'var(--text-main)' }}>शीर्षक (Title) <span style={{ color: '#e53e3e' }}>*</span></label>
                                        <input
                                            type="text"
                                            placeholder="खबर का मुख्य शीर्षक लिखें..."
                                            value={postForm.title}
                                            onChange={e => setPostForm({ ...postForm, title: e.target.value })}
                                            required
                                            style={{ width: '100%', padding: '12px', borderRadius: '8px', border: '1px solid var(--border-color)', background: 'var(--bg-body)', color: 'var(--text-main)', fontSize: '0.9rem', transition: 'border-color 0.2s' }}
                                        />
                                    </div>

                                    <div>
                                        <label style={{ display: 'block', fontSize: '0.82rem', fontWeight: 600, marginBottom: '6px', color: 'var(--text-main)' }}>श्रेणी (Category)</label>
                                        <select
                                            value={postForm.category}
                                            onChange={e => setPostForm({ ...postForm, category: e.target.value })}
                                            style={{ width: '100%', padding: '12px', borderRadius: '8px', border: '1px solid var(--border-color)', background: 'var(--bg-card)', color: 'var(--text-main)', fontSize: '0.9rem', transition: 'border-color 0.2s' }}
                                        >
                                            <option value="ताजा खबर">ताजा खबर</option>
                                            <option value="देश">देश</option>
                                            <option value="राजनीति">राजनीति</option>
                                            <option value="खेल">खेल</option>
                                            <option value="बिजनेस">बिजनेस</option>
                                            <option value="टेक्नोलॉजी">टेक्नोलॉजी</option>
                                            <option value="मनोरंजन">मनोरंजन</option>
                                            <option value="दुनिया">दुनिया</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label style={{ display: 'block', fontSize: '0.82rem', fontWeight: 600, marginBottom: '6px', color: 'var(--text-main)' }}>सामग्री (Content) <span style={{ color: '#e53e3e' }}>*</span></label>
                                        <textarea
                                            placeholder="अपनी खबर या विचार विस्तार से लिखें..."
                                            rows={5}
                                            value={postForm.content}
                                            onChange={e => setPostForm({ ...postForm, content: e.target.value })}
                                            required
                                            style={{ width: '100%', padding: '12px', borderRadius: '8px', border: '1px solid var(--border-color)', background: 'var(--bg-body)', color: 'var(--text-main)', fontSize: '0.9rem', resize: 'vertical', transition: 'border-color 0.2s' }}
                                        />
                                    </div>

                                    <button
                                        type="submit"
                                        disabled={submittingPost}
                                        style={{ width: '100%', padding: '12px', borderRadius: '8px', border: 'none', background: 'var(--primary-color)', color: '#fff', fontSize: '0.95rem', fontWeight: 600, cursor: 'pointer', display: 'flex', alignItems: 'center', justifyContent: 'center', gap: '8px', transition: 'background-color 0.2s, transform 0.1s' }}
                                    >
                                        {submittingPost ? (
                                            <>
                                                <i data-feather="loader" className="feather-spin"></i> समीक्षा की जा रही है...
                                            </>
                                        ) : (
                                            <>
                                                <i data-feather="send"></i> प्रकाशित करें
                                            </>
                                        )}
                                    </button>
                                </form>

                                {/* Moderation Feedback Result */}
                                {postSubmitStatus && (
                                    <div style={{ padding: '14px', borderRadius: '8px', border: postSubmitStatus.success ? '1px solid #10b981' : '1px solid #ef4444', background: postSubmitStatus.success ? 'rgba(16, 185, 129, 0.06)' : 'rgba(239, 68, 68, 0.06)', color: 'var(--text-main)', fontSize: '0.88rem' }}>
                                        <div style={{ fontWeight: 700, display: 'flex', alignItems: 'center', gap: '6px', color: postSubmitStatus.success ? '#10b981' : '#ef4444', marginBottom: '6px' }}>
                                            <i className={postSubmitStatus.success ? "fas fa-check-circle" : "fas fa-exclamation-circle"}></i>
                                            {postSubmitStatus.success ? "पोस्ट सफलतापूर्वक प्रकाशित!" : "प्रकाशन अस्वीकृत"}
                                        </div>
                                        <div style={{ fontSize: '0.85rem' }}>{postSubmitStatus.message}</div>
                                        {postSubmitStatus.aiFeedback && (
                                            <div style={{ marginTop: '8px', paddingTop: '8px', borderTop: '1px dashed rgba(0,0,0,0.08)', fontSize: '0.8rem', color: 'var(--text-muted)' }}>
                                                <strong>समीक्षा विवरण:</strong>
                                                <ul style={{ paddingLeft: '15px', marginTop: '4px', listStyleType: 'disc', display: 'flex', flexDirection: 'column', gap: '2px' }}>
                                                    <li>स्थिति: {postSubmitStatus.success ? 'सुरक्षित (Approved)' : 'प्रतिबंधित सामग्री (Rejected)'}</li>
                                                    {postSubmitStatus.aiFeedback.suggested_category && <li>सुझाई गई श्रेणी: {postSubmitStatus.aiFeedback.suggested_category}</li>}
                                                    {postSubmitStatus.aiFeedback.reason && <li>विवरण: {postSubmitStatus.aiFeedback.reason}</li>}
                                                </ul>
                                            </div>
                                        )}
                                    </div>
                                )}
                            </div>

                            {/* Feed Column */}
                            <div style={{ display: 'flex', flexDirection: 'column', gap: '15px' }}>
                                <h4 style={{ fontSize: '1.15rem', fontWeight: 700, color: 'var(--text-main)', borderBottom: '1px solid var(--border-color)', paddingBottom: '12px', margin: 0, display: 'flex', alignItems: 'center', gap: '8px' }}>
                                    <i data-feather="message-square" style={{ color: 'var(--primary-color)' }}></i>
                                    पाठकों द्वारा हालिया पोस्ट्स
                                </h4>

                                {userPosts.length === 0 ? (
                                    <div style={{ textAlign: 'center', padding: '45px 20px', background: 'var(--bg-card)', border: '1px solid var(--border-color)', borderRadius: '12px', color: 'var(--text-muted)' }}>
                                        <i data-feather="edit" style={{ fontSize: '2.5rem', marginBottom: '10px', color: 'var(--border-color)' }}></i>
                                        <div>अभी तक कोई पोस्ट नहीं है। पहली पोस्ट लिखें!</div>
                                    </div>
                                ) : (
                                    userPosts.map((post, index) => {
                                        
    // Render Feather Icons
    useEffect(() => {
        if (typeof window !== 'undefined' && window.feather) {
            window.feather.replace();
        }
    });

    return (
                                            <div key={index} style={{ background: 'var(--bg-card)', border: '1px solid var(--border-color)', borderLeft: '4px solid var(--primary-color)', borderRadius: '12px', padding: '18px', boxShadow: '0 2px 12px rgba(0,0,0,0.03)', position: 'relative', transition: 'transform 0.2s' }}>
                                                <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', gap: '10px', marginBottom: '10px' }}>
                                                    <span style={{ fontSize: '0.72rem', fontWeight: 700, textTransform: 'uppercase', background: 'rgba(225, 48, 108, 0.08)', color: 'var(--primary-color)', padding: '4px 10px', borderRadius: '6px', border: '1px solid rgba(225, 48, 108, 0.15)' }}>
                                                        {post.category}
                                                    </span>

                                                    <span
                                                        style={{ fontSize: '0.72rem', fontWeight: 700, background: 'rgba(16, 185, 129, 0.08)', color: '#10b981', padding: '4px 10px', borderRadius: '20px', display: 'inline-flex', alignItems: 'center', gap: '4px', border: '1px solid rgba(16, 185, 129, 0.15)' }}
                                                    >
                                                        <i data-feather="check-circle" style={{ fontSize: '0.75rem' }}></i> सत्यापित
                                                    </span>
                                                </div>

                                                <h5 style={{ fontSize: '1.05rem', fontWeight: 700, color: 'var(--text-main)', marginBottom: '8px', lineHeight: 1.45 }}>
                                                    {post.title_hi || post.title}
                                                </h5>

                                                <p style={{ fontSize: '0.88rem', color: 'var(--text-muted)', lineHeight: 1.55, marginBottom: '14px', whiteSpace: 'pre-wrap' }}>
                                                    {post.content_hi || post.content}
                                                </p>

                                                <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', fontSize: '0.78rem', color: 'var(--text-muted)', borderTop: '1px solid rgba(0,0,0,0.05)', paddingTop: '10px' }}>
                                                    <span style={{ fontWeight: 600 }}>
                                                        <i data-feather="user" style={{ marginRight: '5px' }}></i> {post.author_name}
                                                    </span>
                                                    <span>
                                                        <i data-feather="clock" style={{ marginRight: '5px' }}></i> {new Date(post.created_at).toLocaleDateString('hi-IN', { day: 'numeric', month: 'short', hour: '2-digit', minute: '2-digit' })}
                                                    </span>
                                                </div>
                                            </div>
                                        );
                                    })
                                )}
                            </div>
                        </div>
                    </section>

                    {/* 9. Section "फोटो गैलरी" */}
                    <section className="section-wrapper" style={{ position: 'relative', marginBottom: '20px' }}>
                        <div className="section-title-bar">
                            <h3 className="section-title">फोटो गैलरी</h3>
                            <a href="#" className="section-view-all">सभी देखें <i data-feather="chevron-right" style={{ fontSize: '0.75rem' }}></i></a>
                        </div>

                        <div className="gallery-carousel-wrapper">
                            <button className="gallery-control-btn gallery-control-prev" onClick={() => scrollGallery(-1)}>
                                <i data-feather="chevron-left"></i>
                            </button>
                            <div className="gallery-carousel" ref={galleryRef}>
                                {photoGallery.map((photo, idx) => (
                                    <div
                                        key={idx}
                                        className="gallery-item"
                                        onClick={() => handleCardClick(photo.name)}
                                    >
                                        <img src={photo.image} alt={photo.name} loading="lazy" />
                                        <div className="gallery-overlay">{photo.name}</div>
                                    </div>
                                ))}
                            </div>
                            <button className="gallery-control-btn gallery-control-next" onClick={() => scrollGallery(1)}>
                                <i data-feather="chevron-right"></i>
                            </button>
                        </div>
                    </section>

                    {/* Author Card (visible on mobile/tablet only) */}
                    <div className="author-card middle-col-author-card">
                        <div className="author-content">
                            <div className="author-avatar-container">
                                <img src="/images/author_avatar.png" alt="Jasbir Singh" style={{ width: '100%', height: '100%', objectFit: 'cover' }} />
                            </div>
                            <h4 className="author-name">Jasbir Singh</h4>
                            <span className="author-designation">(Chief Editor)</span>
                            <div className="author-divider">
                                <div className="line-long"></div>
                                <div className="line-short"></div>
                            </div>
                            <div className="author-phone">9815529139</div>
                        </div>
                    </div>
                </div>

                {/* Right Column Sticky Sidebar */}
                <aside className="portal-right-col">
                    {/* Short Video (Reels) Widget */}
                    <div className="sidebar-panel short-video-widget" style={{ marginBottom: '20px' }}>
                        <div className="panel-header" style={{ borderBottom: 'none', marginBottom: '10px' }}>
                            <i data-feather="video" className="video-icon" style={{ color: '#e1306c' }}></i>
                            <span>शॉर्ट वीडियो</span>
                        </div>
                        <div
                            className="short-video-card"
                            onClick={() => {
                                setReelsDataset(videoNews);
                                setReelsActiveIndex(0);
                                setReelsOpen(true);
                            }}
                            style={{ position: 'relative', width: '100%', borderRadius: '12px', overflow: 'hidden', background: '#000', cursor: 'pointer', aspectRatio: '9/16', boxShadow: '0 4px 12px rgba(0,0,0,0.15)' }}
                        >
                            <img src="/images/video_delhi_rain.png" alt="Short Video" style={{ width: '100%', height: '100%', objectFit: 'cover', opacity: 0.85 }} />
                            <div style={{ position: 'absolute', inset: 0, background: 'linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 60%)', display: 'flex', flexDirection: 'column', justifyContent: 'space-between', padding: '15px' }}>
                                <div style={{ alignSelf: 'flex-end', background: 'rgba(225, 48, 108, 0.9)', color: '#fff', padding: '2px 8px', borderRadius: '4px', fontSize: '0.75rem', fontWeight: 700 }}>
                                    LIVE
                                </div>
                                <div>
                                    <h4 style={{ color: '#fff', fontSize: '0.95rem', fontWeight: 700, marginBottom: '8px', lineHeight: 1.4, textShadow: '0 1px 2px rgba(0,0,0,0.8)' }}>दिल्ली में बारिश से जलभराव - शॉर्ट वीडियो</h4>
                                    <div style={{ display: 'flex', alignItems: 'center', gap: '8px', color: '#ccc', fontSize: '0.8rem' }}>
                                        <span><i data-feather="eye"></i> 12K व्यूज</span>
                                    </div>
                                </div>
                            </div>
                            <div style={{ position: 'absolute', top: '50%', left: '50%', transform: 'translate(-50%, -50%)', width: '50px', height: '50px', borderRadius: '50%', background: 'rgba(225,48,108,0.9)', display: 'flex', alignItems: 'center', justifyContent: 'center', color: '#fff', fontSize: '1.5rem', boxShadow: '0 4px 10px rgba(0,0,0,0.3)' }}>
                                <i data-feather="play" style={{ marginLeft: '4px' }}></i>
                            </div>
                        </div>
                    </div>

                    {/* Author Card */}
                    <div className="author-card" style={{ marginBottom: '20px' }}>
                        <div className="author-content">
                            <div className="author-avatar-container">
                                <img src="/images/author_avatar.png" alt="Jasbir Singh" style={{ width: '100%', height: '100%', objectFit: 'cover' }} />
                            </div>
                            <h4 className="author-name">Jasbir Singh</h4>
                            <span className="author-designation">(Chief Editor)</span>
                            <div className="author-divider">
                                <div className="line-long"></div>
                                <div className="line-short"></div>
                            </div>
                            <div className="author-phone">9815529139</div>
                        </div>
                    </div>

                    {/* Panel 1: Trending News */}
                    <div className="sidebar-panel">
                        <div className="panel-header">
                            <i data-feather="trending-up" className="trending-icon"></i>
                            <span>ट्रेडिंग न्यूज़</span>
                        </div>
                        <ul className="panel-list">
                            {trendingNews.map((news, idx) => (
                                <li
                                    key={idx}
                                    className="panel-item"
                                    onClick={() => handleCardClick(news.title)}
                                >
                                    <span className="panel-number">{idx + 1}</span>
                                    <div className="panel-item-content">
                                        <h4 className="panel-item-title">{news.title}</h4>
                                        <span className="panel-item-meta">{news.time}</span>
                                    </div>
                                </li>
                            ))}
                        </ul>
                        <button className="panel-more-btn">और देखें</button>
                    </div>

                    {/* Panel 2: Most Read */}
                    <div className="sidebar-panel" style={{ marginTop: '20px' }}>
                        <div className="panel-header">
                            <i data-feather="zap" className="read-icon"></i>
                            <span>सबसे ज्यादा पढ़ी गई</span>
                        </div>
                        <ul className="panel-list">
                            {mostRead.map((news, idx) => (
                                <li
                                    key={idx}
                                    className="panel-item"
                                    onClick={() => handleCardClick(news.title)}
                                >
                                    <span className="panel-number">{idx + 1}</span>
                                    <div className="panel-item-content">
                                        <h4 className="panel-item-title">{news.title}</h4>
                                        <span className="panel-item-meta">{news.views}</span>
                                    </div>
                                </li>
                            ))}
                        </ul>
                        <button className="panel-more-btn">और देखें</button>
                    </div>

                    {/* Premium Support Ad Panel */}
                    <div className="sidebar-ad-card" style={{ marginTop: '20px', background: 'linear-gradient(135deg, #f53d3d, #c92222)', padding: '25px', borderRadius: '12px', color: '#fff', textAlign: 'center', boxShadow: '0 4px 15px rgba(229,62,62,0.2)' }}>
                        <h4 style={{ fontSize: '1.2rem', fontWeight: '700', marginBottom: '8px' }}>AAKASH NEWS 24 प्रीमियम</h4>
                        <p style={{ fontSize: '0.85rem', opacity: 0.9, marginBottom: '15px', lineHeight: 1.4 }}>निष्पक्ष पत्रकारिता का समर्थन करें। आज ही सदस्यता लें।</p>
                        <button style={{ background: '#fff', color: '#e53e3e', border: 'none', padding: '10px 20px', borderRadius: '6px', fontWeight: '700', cursor: 'pointer', transition: 'transform 0.2s' }}>अभी सदस्यता लें</button>
                    </div>
                </aside>
            </div>

            {/* 10. Newsletter Subscription Bar */}
            <section className="newsletter-bar">
                <div className="container newsletter-container">
                    <div className="newsletter-left">
                        <div className="newsletter-icon-wrapper">
                            <i data-feather="mail"></i>
                        </div>
                        <div className="newsletter-text">
                            <h3>लेटेस्ट खबरों, ब्रेकिंग न्यूज़ और एक्सक्लूसिव स्टोरीज के लिए न्यूज़लेटर सब्सक्राइब करें</h3>
                        </div>
                    </div>
                    <form className="newsletter-form" onSubmit={handleSubscribe}>
                        <input
                            type="email"
                            className="newsletter-input"
                            placeholder="अपना ईमेल पता लिखें"
                            value={email}
                            onChange={(e) => setEmail(e.target.value)}
                            required
                        />
                        <button type="submit" className="newsletter-submit">सब्सक्राइब करें</button>
                    </form>
                </div>
            </section>

            {/* Custom Dialog/Modal for success notification */}
            <div className={`subscribed-modal ${modalOpen ? 'show' : ''}`}>
                <div className="modal-icon">
                    <i data-feather="check-circle"></i>
                </div>
                <h3 style={{ fontSize: '1.3rem', marginBottom: '10px', fontWeight: '700' }}>सफलता!</h3>
                <p style={{ fontSize: '0.95rem', color: 'var(--text-muted)' }}>{modalMsg}</p>
                <button className="modal-close-btn" onClick={() => setModalOpen(false)}>ठीक है</button>
            </div>

            {/* 11. Footer */}
            <footer>
                <div className="container footer-grid">
                    <div className="footer-logo-col">
                        <a href="/" className="footer-logo" style={{ display: 'flex', alignItems: 'center', gap: '10px', marginBottom: '15px' }}>
                            <img src="/images/logo.png" alt="Aakash News 24" style={{ height: '40px', width: '40px', borderRadius: '50%', border: '2px solid rgba(255,255,255,0.2)' }} />
                            <span style={{ color: '#fff', fontWeight: 900, fontSize: '1.35rem' }}>AAKASH <span style={{ color: '#e53e3e' }}>NEWS 24</span></span>
                        </a>
                        <p>Always Ahead। हम आपको प्रदान करते हैं देश और दुनिया की ताज़ा और विश्वसनीय ख़बरें सबसे पहले।</p>
                        <div className="social-links">
                            <a href="#" className="social-btn" aria-label="Facebook"><i data-feather="facebook"></i></a>
                            <a href="#" className="social-btn" aria-label="Twitter"><i data-feather="twitter"></i></a>
                            <a href="#" className="social-btn" aria-label="Instagram"><i data-feather="instagram"></i></a>
                            <a href="#" className="social-btn" aria-label="Youtube"><i data-feather="youtube"></i></a>
                        </div>
                    </div>

                    <div className="footer-links-col">
                        <h4>एक्सप्लोर</h4>
                        <ul className="footer-links">
                            <li><a href="#">होम</a></li>
                            <li><a href="#">देश</a></li>
                            <li><a href="#">राज्य</a></li>
                            <li><a href="#">दुनिया</a></li>
                            <li><a href="#">वीडियो</a></li>
                            <li><a href="#">फोटो गैलरी</a></li>
                        </ul>
                    </div>

                    <div className="footer-links-col">
                        <h4>कैटेगरी</h4>
                        <ul className="footer-links">
                            <li><a href="#">राजनीति</a></li>
                            <li><a href="#">खेल</a></li>
                            <li><a href="#">बिजनेस</a></li>
                            <li><a href="#">टेक्नोलॉजी</a></li>
                            <li><a href="#">मनोरंजन</a></li>
                            <li><a href="#">लाइफस्टाइल</a></li>
                        </ul>
                    </div>

                    <div className="footer-links-col">
                        <h4>सहायता</h4>
                        <ul className="footer-links">
                            <li><a href="#">हमारे बारे में</a></li>
                            <li><a href="#">संपर्क करें</a></li>
                            <li><a href="#">गोपनीयता नीति</a></li>
                            <li><a href="#">नियम & शर्तें</a></li>
                            <li><a href="#">FAQ</a></li>
                        </ul>
                    </div>

                    <div className="footer-app-col">
                        <h4>मोबाइल ऐप डाउनलोड करें</h4>
                        <div className="app-badges">
                            <div className="app-badge-btn">
                                <i data-feather="play"></i>
                                <div>
                                    <span>GET IT ON</span>
                                    <strong>Google Play</strong>
                                </div>
                            </div>
                            <div className="app-badge-btn">
                                <i data-feather="smartphone"></i>
                                <div>
                                    <span>Download on the</span>
                                    <strong>App Store</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="copyright-bar">
                    &copy; 2026 Aakash News 24. सभी अधिकार सुरक्षित।
                </div>
            </footer>

            {/* Reels Viewer Overlay (Dainik Bhaskar Style) */}
            {reelsOpen && reelsDataset.length > 0 && (
                <div id="reels-viewer-overlay" className="reels-viewer-overlay">
                    <button className="reels-close-btn" onClick={closeReels} aria-label="बंद करें">
                        &times;
                    </button>

                    <div className="reels-container-wrapper">
                        {/* Up / Previous Arrow */}
                        <button
                            className="reels-nav-arrow"
                            style={{ position: 'absolute', top: '-70px', left: '50%', transform: 'translateX(-50%)' }}
                            onClick={() => reelsActiveIndex > 0 && setReelsActiveIndex(prev => prev - 1)}
                            disabled={reelsActiveIndex === 0}
                        >
                            <i data-feather="chevron-up"></i>
                        </button>

                        <div
                            className="reels-scroll-container"
                            ref={reelsScrollRef}
                            onScroll={handleReelsScroll}
                        >
                            {reelsDataset.map((video, idx) => (
                                <div key={idx} className="reel-slide">
                                    <div className="reel-iframe-wrapper">
                                        <iframe
                                            ref={el => iframeRefs.current[idx] = el}
                                            src={idx === reelsActiveIndex ? (video.embed_url + (video.embed_url.includes('youtube.com') && !video.embed_url.includes('autoplay=1') ? (video.embed_url.includes('?') ? '&' : '?') + 'autoplay=1&mute=0' : '')) : ''}
                                            allow="autoplay; encrypted-media"
                                            allowFullScreen
                                            title={video.title || "Reel Video"}
                                        ></iframe>
                                    </div>

                                    {/* Category Pill */}
                                    <div className="reel-category-pill">
                                        <i data-feather="tag"></i>
                                        <span>{video.category || 'मनोरंजन'} &gt;</span>
                                    </div>

                                    {/* Video Controls Bar */}
                                    <div className="reel-controls-bar">
                                        <div className="reel-timeline-container">
                                            <span>{Math.floor(reelsCurrentTime / 60)}:{String(reelsCurrentTime % 60).padStart(2, '0')}</span>
                                            <input
                                                type="range"
                                                className="reel-timeline-slider"
                                                min="0"
                                                max={reelsDuration}
                                                value={reelsCurrentTime}
                                                onChange={(e) => seekReelsTime(parseInt(e.target.value, 10))}
                                            />
                                            <span>{Math.floor(reelsDuration / 60)}:{String(reelsDuration % 60).padStart(2, '0')}</span>
                                        </div>

                                        <div className="reel-buttons-row">
                                            <div className="reel-left-controls">
                                                <button className="reel-speed-btn" onClick={toggleReelsSpeed}>
                                                    {reelsSpeed}x
                                                </button>
                                            </div>
                                            <div className="reel-center-controls">
                                                <button className="reel-control-btn" onClick={() => skipReelsTime(-5)} title="-5s">
                                                    <i data-feather="rewind"></i>
                                                </button>
                                                <button className="reel-control-btn play-pause-btn" onClick={toggleReelsPlayPause} style={{ fontSize: '1.4rem' }}>
                                                    <i className={reelsPlaying ? 'fas fa-pause' : 'fas fa-play'}></i>
                                                </button>
                                                <button className="reel-control-btn" onClick={() => skipReelsTime(5)} title="+5s">
                                                    <i data-feather="fast-forward"></i>
                                                </button>
                                            </div>
                                            <div className="reel-right-controls">
                                                <button className="reel-control-btn volume-btn" onClick={toggleReelsMute}>
                                                    <i className={reelsMuted ? 'fas fa-volume-mute' : 'fas fa-volume-up'}></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    {/* Info Overlay */}
                                    <div className="reel-info-overlay">
                                        <div className="reel-brand-header" style={{ display: 'flex', alignItems: 'center', gap: '8px' }}>
                                            <img src="/images/logo.png" alt="Aakash News 24" style={{ height: '24px', width: '24px', borderRadius: '50%' }} />
                                            <span className="reel-brand-logo" style={{ fontSize: '0.9rem', fontWeight: 800 }}>AAKASH NEWS 24</span>
                                            <button className="reel-read-news-btn" onClick={() => handleCardClick(video.title)}>खबर पढ़ें</button>
                                        </div>
                                        <h3 className="reel-title">{video.title || 'शॉर्ट वीडियो'}</h3>
                                        <div className="reel-meta-info">
                                            <span><i data-feather="clock"></i> {video.time || 'अभी-अभी'}</span>
                                            {video.views && <span><i data-feather="eye"></i> {video.views}</span>}
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>

                        {/* Down / Next Arrow */}
                        <button
                            className="reels-nav-arrow"
                            style={{ position: 'absolute', bottom: '-70px', left: '50%', transform: 'translateX(-50%)' }}
                            onClick={() => reelsActiveIndex < reelsDataset.length - 1 && setReelsActiveIndex(prev => prev + 1)}
                            disabled={reelsActiveIndex === reelsDataset.length - 1}
                        >
                            <i data-feather="chevron-down"></i>
                        </button>

                        {/* Floating Actions Sidebar */}
                        <div className="reels-sidebar-actions">
                            <a
                                className="reels-action-circle facebook"
                                href={`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(reelsDataset[reelsActiveIndex]?.url || '')}`}
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                <i data-feather="facebook"></i>
                                <span>फेसबुक</span>
                            </a>
                            <a
                                className="reels-action-circle twitter"
                                href={`https://twitter.com/intent/tweet?url=${encodeURIComponent(reelsDataset[reelsActiveIndex]?.url || '')}&text=${encodeURIComponent(reelsDataset[reelsActiveIndex]?.title || '')}`}
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                <i data-feather="twitter"></i>
                                <span>ट्विटर</span>
                            </a>
                            <button className="reels-action-circle copy-link" onClick={copyReelsLink}>
                                <i data-feather="link"></i>
                                <span>लिंक</span>
                            </button>
                        </div>
                    </div>

                    {/* Bottom Caption Bar */}
                    <div className="reels-bottom-caption-bar">
                        <span>वीडियो: <strong className="reels-caption-highlight">{reelsDataset[reelsActiveIndex]?.title || 'शॉर्ट वीडियो'}</strong></span>
                    </div>
                </div>
            )}

            {/* Custom Interactive Toast */}
            {toastActive && (
                <div
                    className="toast-notification"
                    style={{
                        opacity: 1,
                        transform: 'translateY(0)',
                        position: 'fixed',
                        bottom: '30px',
                        right: '30px',
                        zIndex: 500,
                        transition: 'all 0.3s ease'
                    }}
                >
                    <div style={{
                        backgroundColor: 'var(--bg-card)',
                        color: 'var(--text-main)',
                        borderLeft: '4px solid var(--primary-color)',
                        padding: '15px 20px',
                        borderRadius: '8px',
                        boxShadow: '0 10px 15px -3px rgba(0,0,0,0.15)',
                        display: 'flex',
                        alignItems: 'center',
                        gap: '10px'
                    }}>
                        <i data-feather="info" style={{ color: 'var(--primary-color)', fontSize: '1.25rem' }}></i>
                        <span style={{ fontWeight: 600, fontSize: '0.9rem' }}>{toastMsg}</span>
                    </div>
                </div>
            )}
        </>
    );
}
