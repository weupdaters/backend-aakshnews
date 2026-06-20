const express = require('express');
const path = require('path');
const app = express();
const PORT = process.env.PORT || 3000;

// Set view engine to EJS
app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));

// Serve static files from 'public' directory
app.use(express.static(path.join(__dirname, 'public')));
app.use(express.json());

// Mock News Data (matching the screenshot exactly)
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
        image: "/images/video_delhi_rain.png"
    },
    {
        title: "भारत की शानदार जीत",
        time: "2 घंटे पहले",
        views: "18K व्यूज",
        duration: "03:10",
        image: "/images/video_cricket.png"
    },
    {
        title: "राहुल गांधी का बड़ा बयान",
        time: "3 घंटे पहले",
        views: "8K व्यूज",
        duration: "01:50",
        image: "/images/video_rahul.png"
    },
    {
        title: "नई इलेक्ट्रिक कार लॉन्च",
        time: "4 घंटे पहले",
        views: "7K व्यूज",
        duration: "02:30",
        image: "/images/video_electric_car.png"
    },
    {
        title: "अंतरिक्ष में भारत का कमाल",
        time: "5 घंटे पहले",
        views: "11K व्यूज",
        duration: "02:20",
        image: "/images/video_space.png"
    }
];

const categoriesNews = [
    {
        name: "राजनीति",
        icon: "fa-landmark",
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
        icon: "fa-running",
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
        icon: "fa-briefcase",
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
        icon: "fa-microchip",
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
        icon: "fa-globe",
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

const instagramVideos = [
    {
        id: 1,
        title: "पंजाब में 5 दिन बिजली बंद, जानें सच",
        embed_url: "https://www.instagram.com/p/C741tV_v_V0/embed/",
        url: "https://www.instagram.com/p/C741tV_v_V0/",
        timeAgo: "3 दिन पहले"
    },
    {
        id: 2,
        title: "We are hiring! Join our team as a news reporter.",
        embed_url: "https://www.instagram.com/p/C741tV_v_V1/embed/",
        url: "https://www.instagram.com/p/C741tV_v_V1/",
        timeAgo: "5 दिन पहले"
    },
    {
        id: 3,
        title: "We are hiring! Video editors wanted.",
        embed_url: "https://www.instagram.com/p/C741tV_v_V2/embed/",
        url: "https://www.instagram.com/p/C741tV_v_V2/",
        timeAgo: "7 दिन पहले"
    }
];

// Routes
app.get('/', (req, res) => {
    const today = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const dateString = today.toLocaleDateString('hi-IN', options);

    res.render('index', {
        dateString,
        breakingNews,
        heroMain,
        heroMiddleStack,
        trendingNews,
        mostRead,
        latestNews,
        videoNews,
        categoriesNews,
        photoGallery,
        instagramVideos
    });
});

// API endpoint for newsletter subscription
app.post('/api/subscribe', (req, res) => {
    const { email } = req.body;
    if (!email || !email.includes('@')) {
        return res.status(400).json({ success: false, message: "कृपया एक वैध ईमेल पता दर्ज करें।" });
    }
    return res.json({ success: true, message: "न्यूज़लेटर सदस्यता के लिए धन्यवाद!" });
});

// Start server
app.listen(PORT, () => {
    console.log(`Server running at http://127.0.0.1:${PORT}`);
});
