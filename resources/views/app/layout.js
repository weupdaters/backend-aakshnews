import './globals.css';

export const metadata = {
  title: 'Aakash News 24 | Always Ahead | Hindi News Portal',
  description: 'Aakash News 24 - Always Ahead। हिंदी न्यूज़ पोर्टल। देश, दुनिया, खेल, राजनीति, बिजनेस और टेक्नोलॉजी की ताज़ा ख़बरें.',
};

export default function RootLayout({ children }) {
  
    // Render Feather Icons
    useEffect(() => {
        if (typeof window !== 'undefined' && window.feather) {
            window.feather.replace();
        }
    });

    return (
    <html lang="hi">
      <head>
        {/* FontAwesome for Premium Icons */}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
      </head>
      <body>
        {children}
      </body>
    </html>
  );
}
