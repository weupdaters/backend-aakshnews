import { NextResponse } from 'next/server';

export async function POST(request) {
    try {
        const { email } = await request.json();
        
        if (!email || !email.includes('@')) {
            return NextResponse.json(
                { success: false, message: 'कृपया एक वैध ईमेल पता दर्ज करें।' },
                { status: 400 }
            );
        }
        
        return NextResponse.json({
            success: true,
            message: 'न्यूज़लेटर सदस्यता के लिए धन्यवाद!'
        });
    } catch (error) {
        console.error('Subscription error:', error);
        return NextResponse.json(
            { success: false, message: 'सर्वर त्रुटि: कृपया पुनः प्रयास करें।' },
            { status: 500 }
        );
    }
}
