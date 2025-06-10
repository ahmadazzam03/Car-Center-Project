<x-app-layout title="EV Charging Stations Map">
    <style>
        .map-container {
            position: relative;
            width: 100%;
            height: 600px;
        }
        .map-controls {
            position: absolute;
            top: 90px;
            left: 12%;
            transform: translateX(-50%);
            z-index: 1000;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 8px;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            display: flex;
            gap: 8px;
        }
        .btn {
            padding: 10px 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-primary {
            background-color: #4285F4;
            color: white;
        }
        .btn-secondary {
            background-color: #f1f1f1;
            color: #333;
        }
        .btn-icon {
            position: absolute;
            left:5px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            
        }
        .user-location-icon {
            width: 24px;
            height: 24px;
            background-color: #4285F4;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.3);
            position: relative;
            animation: pulse 2s infinite;
        }
        .user-location-icon::after {
            content: '';
            position: absolute;
            width: 8px;
            height: 8px;
            background-color: white;
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
    <div class="map-container">
    {{-- Map container --}}
    <div id="map" style="width:100%;height:600px;"></div>
    {{-- To call a map from google cloud api --}}
    <div class="map-controls">
        <button onclick="showNearbyStations()" class="btn btn-primary ">
            <span class="btn-icon"><i class="fas fa-search-location"></i></span>
            Show Nearby Stations
        </button>
        <button onclick="toggleDarkMode()" class="btn btn-secondary ">
            <span class="btn-icon"><i class="fas fa-moon"></i></span> 
            Satellite Mode
        </button>
    </div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNh3PLMYcA7E1MaCQEmKEqlfrvmYcLgaI&callback=initMap&loading=async" async defer></script>
    <script>
        var map;
        var userMarker = null; // User location marker
        var userLat, userLng; // User coordinates
        var markers = []; // Array to store markers
        var stationsShown = false; // Stations display state

        function initMap() {
            // Create map with default center (will be updated later)
            map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: 31.963158, lng: 35.930359 }, // Default center (Amman, Jordan)
                zoom: 13,
            });
            
            // Try to get user location automatically when page loads
            getCurrentLocation();
        }
        function toggleDarkMode() {
            const isDark = map.getMapTypeId() === 'roadmap';
            map.setMapTypeId(isDark ? 'hybrid' : 'roadmap');
        }
        
        function getCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        userLat = position.coords.latitude;
                        userLng = position.coords.longitude;
                        
                        // Update map center to user location
                        map.setCenter({ lat: userLat, lng: userLng });
                        
                        // Place marker for user location
                        placeUserMarker(userLat, userLng);
                        
                        // Show message to user
                        Swal.fire({
                            title: "Location Found!",
                            text: "Your current location has been detected. Click 'Show Nearby Stations' to view charging stations near you.",
                            icon: "success"
                        });
                    },
                    (error) => {
                        console.error('Error getting user location:', error);
                        Swal.fire({
                            title: "Warning!",
                            text: "Could not retrieve your location. Please make sure location services are enabled or use the button to manually update your location.",
                            icon: "warning"
                        });
                    },
                    {
                        enableHighAccuracy: true, // Higher accuracy
                        timeout: 10000, // Wait 10 seconds for location
                        maximumAge: 0 // Don't use cached location
                    }
                );
            } else {
                Swal.fire({
                    title: "Warning!",
                    text: "Your browser doesn't support geolocation services.",
                    icon: "warning"
                });
            }
        }
        
        function showNearbyStations() {
            if (!userLat || !userLng) {
                Swal.fire({
                    title: "Warning!",
                    text: "Your location hasn't been detected yet. Please allow location sharing or try again.",
                    icon: "warning"
                });
                return;
            }
            
            if (stationsShown) {
                // If stations are already shown, hide them
                if (markers.length > 0) {
                    markers.forEach(marker => marker.setMap(null));
                    markers = [];
                }
                stationsShown = false;
                Swal.fire({
                    title: "Stations Hidden",
                    text: "All charging stations have been hidden from the map.",
                    icon: "info"
                });
            } else {
                // Show nearby stations
                showNearbyMarkers(userLat, userLng);
                stationsShown = true;
                Swal.fire({
                    title: "Stations Loaded!",
                    text: "Nearby charging stations have been displayed on the map.",
                    icon: "success"
                });
            }
        }

        // Function to place user location marker
        function placeUserMarker(lat, lng) {
            if (userMarker) {
                userMarker.setMap(null); // Remove old marker if exists
            }
    
            const userIcon = {
                path: google.maps.SymbolPath.CIRCLE,
                scale: 12,
                fillColor: '#4285F4',
                fillOpacity: 1,
                strokeColor: 'white',
                strokeWeight: 2,
            };
            const userLocationDiv = document.createElement('div');
            userLocationDiv.className = 'user-location-icon';

            // Use the default Google Maps blue dot for user location
            userMarker = new google.maps.Marker({
                map: map,
                position: { lat: lat, lng: lng },
                title: 'Your Current Location',
                icon: {
                    url: 'data:image/svg+xml;utf-8,' + encodeURIComponent(`
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="8" fill="#4285F4" stroke="white" stroke-width="2"/>
                            <circle cx="12" cy="12" r="3" fill="white"/>
                        </svg>
                    `),
                    scaledSize: new google.maps.Size(24, 24),
                    anchor: new google.maps.Point(12, 12)
                },
                zIndex: 999
            });

    
            // Add info window for user marker
            const infoWindow = new google.maps.InfoWindow({
                content: `<strong>Your Location</strong><br>Latitude: ${lat.toFixed(6)}<br>Longitude: ${lng.toFixed(6)}`
            });
    
            userMarker.addListener('click', function () {
                infoWindow.open(map, userMarker);
            });
        }
    
        // Function to show nearby markers
        function showNearbyMarkers(userLat, userLng) {
            const maxDistance = 50; // Maximum distance in kilometers
    
            // Remove old markers if they exist
            if (markers.length > 0) {
                markers.forEach(marker => marker.setMap(null));
                markers = []; // Reset markers array
            }
    
            var locations = [
    // عمان (25 محطة)
    {
        position: { lat: 31.963158, lng: 35.930359 },
        title: 'محطة شحن العبدلي السريعة',
        info: 'شارع الملك عبدالله الثاني، عمّان',
        rating: 4,
        hours: "24/7",
        phone: "06 552 0001",
        type: "fast"
    },
    {
        position: { lat: 31.956789, lng: 35.945678 },
        title: 'محطة مناصير - الصويفية',
        info: 'مجمع الصويفية التجاري',
        rating: 5,
        hours: "6:00 AM - 12:00 AM",
        phone: "06 552 0002",
        type: "manaseer"
    },
    {
        position: { lat: 31.985674, lng: 35.851234 },
        title: 'محطة شحن الدوار السابع',
        info: 'مقابل فندق كمبينسكي',
        rating: 4,
        hours: "6:00 AM - 11:00 PM",
        phone: "06 552 0003",
        type: "fast"
    },
    {
        position: { lat: 31.952123, lng: 35.910456 },
        title: 'محطة توتال - الشميساني',
        info: 'شارع زهران',
        rating: 3,
        hours: "24/7",
        phone: "06 552 0004",
        type: "total"
    },
    {
        position: { lat: 31.970423, lng: 35.847456 },
        title: 'محطة شحن عبدون',
        info: 'شارع عبدون الرئيسي',
        rating: 4,
        hours: "6:00 AM - 12:00 AM",
        phone: "06 552 0005",
        type: "standard"
    },
    {
        position: { lat: 31.978456, lng: 35.912345 },
        title: 'محطة شحن المدينة الطبية',
        info: 'مواقف المستشفى الإسلامي',
        rating: 5,
        hours: "24/7",
        phone: "06 552 0006",
        type: "fast"
    },
    {
        position: { lat: 31.987654, lng: 35.876543 },
        title: 'محطة شحن خلدا',
        info: 'شارع الأردن',
        rating: 4,
        hours: "6:00 AM - 11:00 PM",
        phone: "06 552 0007",
        type: "standard"
    },
    {
        position: { lat: 31.912345, lng: 35.876543 },
        title: 'محطة شحن الجبيهة',
        info: 'شارع الجامعة الأردنية',
        rating: 3,
        hours: "8:00 AM - 10:00 PM",
        phone: "06 552 0008",
        type: "standard"
    },
    {
        position: { lat: 31.876543, lng: 35.912345 },
        title: 'محطة شحن المقابلين',
        info: 'شارع المقابلين الرئيسي',
        rating: 4,
        hours: "24/7",
        phone: "06 552 0009",
        type: "standard"
    },
    {
        position: { lat: 31.912345, lng: 35.876543 },
        title: 'محطة شحن أبو نصير',
        info: 'شارع أبو نصير',
        rating: 3,
        hours: "6:00 AM - 11:00 PM",
        phone: "06 552 0010",
        type: "standard"
    },
    {
        position: { lat: 31.987654, lng: 35.876543 },
        title: 'محطة شحن سحاب',
        info: 'المنطقة الصناعية',
        rating: 4,
        hours: "24/7",
        phone: "06 552 0011",
        type: "fast"
    },
    {
        position: { lat: 32.012345, lng: 35.876543 },
        title: 'محطة شحن ناعور',
        info: 'شارع ناعور الرئيسي',
        rating: 3,
        hours: "8:00 AM - 10:00 PM",
        phone: "06 552 0012",
        type: "standard"
    },
    {
        position: { lat: 31.950000, lng: 35.820000 },
        title: 'محطة شحن وادي السير',
        info: 'شارع وادي السير الرئيسي',
        rating: 4,
        hours: "6:00 AM - 11:00 PM",
        phone: "06 552 0013",
        type: "standard"
    },
    {
        position: { lat: 31.995577, lng: 35.998799 },
        title: 'محطة شحن ماركا',
        info: 'شارع الملك عبدالله الأول',
        rating: 5,
        hours: "24/7",
        phone: "06 552 0014",
        type: "fast"
    },
    {
        position: { lat: 32.012345, lng: 35.876543 },
        title: 'محطة شحن صويلح',
        info: 'شارع الأمير حمزة',
        rating: 4,
        hours: "6:00 AM - 12:00 AM",
        phone: "06 552 0015",
        type: "standard"
    },
    {
        position: { lat: 31.996925, lng: 35.837650 },
        title: 'محطة شحن طبربور',
        info: 'شارع وصفي التل',
        rating: 3,
        hours: "8:00 AM - 10:00 PM",
        phone: "06 552 0016",
        type: "standard"
    },
    {
        position: { lat: 31.862697, lng: 35.927059 },
        title: 'محطة شحن اليادودة',
        info: 'شارع اليادودة الرئيسي',
        rating: 5,
        hours: "24/7",
        phone: "06 552 0017",
        type: "fast"
    },
    {
        position: { lat: 31.913162, lng: 35.897472 },
        title: 'محطة شحن المناصير - القدس',
        info: 'دوار الداخلية',
        rating: 4,
        hours: "6:00 AM - 11:00 PM",
        phone: "06 552 0018",
        type: "manaseer"
    },
    {
        position: { lat: 31.915588, lng: 35.896365 },
        title: 'محطة شحن القدس العربية',
        info: 'شارع القدس',
        rating: 3,
        hours: "24/7",
        phone: "06 552 0019",
        type: "standard"
    },
    {
        position: { lat: 31.964443, lng: 35.888425 },
        title: 'محطة شحن وادي صقرة',
        info: 'شارع عرار',
        rating: 4,
        hours: "6:00 AM - 12:00 AM",
        phone: "06 552 0020",
        type: "standard"
    },
    {
        position: { lat: 31.956789, lng: 35.945678 },
        title: 'محطة شحن الدوار الرابع',
        info: 'شارع المدينة المنورة',
        rating: 5,
        hours: "24/7",
        phone: "06 552 0021",
        type: "fast"
    },
    {
        position: { lat: 31.987654, lng: 35.876543 },
        title: 'محطة شحن تلاع العلي',
        info: 'شارع تلاع العلي الرئيسي',
        rating: 4,
        hours: "6:00 AM - 11:00 PM",
        phone: "06 552 0022",
        type: "standard"
    },
    {
        position: { lat: 31.876543, lng: 35.912345 },
        title: 'محطة شحن القويسمة',
        info: 'شارع القويسمة الرئيسي',
        rating: 3,
        hours: "8:00 AM - 10:00 PM",
        phone: "06 552 0023",
        type: "standard"
    },
    {
        position: { lat: 31.912345, lng: 35.876543 },
        title: 'محطة شحن الجبيهة الشمالية',
        info: 'شارع الجبيهة الشمالية',
        rating: 4,
        hours: "6:00 AM - 12:00 AM",
        phone: "06 552 0024",
        type: "standard"
    },
    {
        position: { lat: 31.987654, lng: 35.876543 },
        title: 'محطة شحن خلدا الشمالية',
        info: 'شارع خلدا الشمالية',
        rating: 5,
        hours: "24/7",
        phone: "06 552 0025",
        type: "fast"
    },

    // الزرقاء (8 محطات)
    {
        position: { lat: 32.097078, lng: 36.087199 },
        title: 'محطة شحن الزرقاء السريعة',
        info: 'المنطقة الصناعية، الزرقاء',
        rating: 4,
        hours: "24/7",
        phone: "05 552 1001",
        type: "fast"
    },
    {
        position: { lat: 32.104277, lng: 36.109086 },
        title: 'محطة شحن المصفاة',
        info: 'شارع المصفاة',
        rating: 3,
        hours: "6:00 AM - 11:00 PM",
        phone: "05 552 1002",
        type: "standard"
    },
    {
        position: { lat: 32.063482, lng: 36.077849 },
        title: 'محطة شحن أبناء شريم',
        info: 'الزرقاء',
        rating: 4,
        hours: "24/7",
        phone: "05 552 1003",
        type: "standard"
    },
    {
        position: { lat: 32.048643, lng: 36.084373 },
        title: 'محطة شحن الحرمين',
        info: 'شارع الحرمين',
        rating: 5,
        hours: "6:00 AM - 12:00 AM",
        phone: "05 552 1004",
        type: "fast"
    },
    {
        position: { lat: 32.034965, lng: 36.026351 },
        title: 'محطة شحن الرصيفة',
        info: 'شارع ياجوز',
        rating: 3,
        hours: "8:00 AM - 10:00 PM",
        phone: "05 552 1005",
        type: "standard"
    },
    {
        position: { lat: 32.021576, lng: 36.082656 },
        title: 'محطة شحن LionCharge',
        info: 'الزرقاء',
        rating: 4,
        hours: "24/7",
        phone: "05 552 1006",
        type: "fast"
    },
    {
        position: { lat: 32.089036, lng: 36.112926 },
        title: 'محطة شحن الزرقاء الجديدة',
        info: 'شارع الأمير محمد',
        rating: 5,
        hours: "6:00 AM - 11:00 PM",
        phone: "05 552 1007",
        type: "standard"
    },
    {
        position: { lat: 32.050000, lng: 36.080000 },
        title: 'محطة شحن المنطقة الصناعية',
        info: 'المنطقة الصناعية',
        rating: 4,
        hours: "24/7",
        phone: "05 552 1008",
        type: "fast"
    },

    // إربد (7 محطات)
    {
        position: { lat: 32.563994, lng: 35.834226 },
        title: 'محطة شحن إربد المركزية',
        info: 'شارع الجامعة، إربد',
        rating: 4,
        hours: "6:00 AM - 11:00 PM",
        phone: "02 552 2001",
        type: "standard"
    },
    {
        position: { lat: 32.556760, lng: 35.859289 },
        title: 'محطة شحن YallaCharge',
        info: 'شارع راتب البطاينة',
        rating: 5,
        hours: "24/7",
        phone: "02 552 2002",
        type: "fast"
    },
    {
        position: { lat: 32.536791, lng: 35.843839 },
        title: 'محطة شحن الرازي',
        info: 'شارع الرازي',
        rating: 3,
        hours: "8:00 AM - 10:00 PM",
        phone: "02 552 2003",
        type: "standard"
    },
    {
        position: { lat: 32.544606, lng: 35.845899 },
        title: 'محطة شحن إربد الشمالية',
        info: 'شارع الشمال',
        rating: 4,
        hours: "6:00 AM - 12:00 AM",
        phone: "02 552 2004",
        type: "standard"
    },
    {
        position: { lat: 32.518555, lng: 35.872335 },
        title: 'محطة شحن إربد الجنوبية',
        info: 'شارع الجنوب',
        rating: 5,
        hours: "24/7",
        phone: "02 552 2005",
        type: "fast"
    },
    {
        position: { lat: 32.558765, lng: 36.008765 },
        title: 'محطة شحن الرمثا',
        info: 'شارع الجامعة الهاشمية',
        rating: 3,
        hours: "8:00 AM - 10:00 PM",
        phone: "02 552 2006",
        type: "standard"
    },
    {
        position: { lat: 32.280000, lng: 35.890000 },
        title: 'محطة شحن جرش',
        info: 'شارع المدينة الأثرية',
        rating: 4,
        hours: "6:00 AM - 11:00 PM",
        phone: "02 552 2007",
        type: "standard"
    },

    // العقبة (5 محطات)
    {
        position: { lat: 29.526234, lng: 35.007654 },
        title: 'محطة شحن العقبة البحرية',
        info: 'المنطقة السياحية، العقبة',
        rating: 5,
        hours: "24/7",
        phone: "03 552 3001",
        type: "fast"
    },
    {
        position: { lat: 29.540000, lng: 34.990000 },
        title: 'محطة شحن العقبة الجنوبية',
        info: 'قرب فندق موفنبيك',
        rating: 4,
        hours: "6:00 AM - 12:00 AM",
        phone: "03 552 3002",
        type: "standard"
    },
    {
        position: { lat: 29.550000, lng: 34.950000 },
        title: 'محطة شحن المنطقة الاقتصادية',
        info: 'المنطقة الاقتصادية الخاصة',
        rating: 3,
        hours: "8:00 AM - 10:00 PM",
        phone: "03 552 3003",
        type: "standard"
    },
    {
        position: { lat: 29.560000, lng: 34.960000 },
        title: 'محطة شحن العقبة الشمالية',
        info: 'شارع الملك حسين',
        rating: 4,
        hours: "6:00 AM - 11:00 PM",
        phone: "03 552 3004",
        type: "standard"
    },
    {
        position: { lat: 29.530000, lng: 34.980000 },
        title: 'محطة شحن العقبة الغربية',
        info: 'شارع الغرب',
        rating: 5,
        hours: "24/7",
        phone: "03 552 3005",
        type: "fast"
    },

    // المحافظات الأخرى (10 محطات)
    {
        position: { lat: 30.192056, lng: 35.735264 },
        title: 'محطة شحن معان',
        info: 'شارع الملك حسين، معان',
        rating: 3,
        hours: "8:00 AM - 10:00 PM",
        phone: "03 552 4001",
        type: "standard"
    },
    {
        position: { lat: 32.34132031751032,   lng: 36.2205815610138},
        title: 'محطة شحن للسيارات الكهربائية',
        info: 'شارع الجامعة، المفرق',
        rating: 4,
        hours: "6:00 AM - 11:00 PM",
        phone: "02 552 4002",
        type: "standard"
    },
        {
        position: { lat: 32.33092527702422,  lng: 36.283424361013786 },
        title: 'محطة شحن للمركبات الكهربائية',
        info: 'شارع بغداد، المفرق',
        rating: 5,
        hours: "24/7",
        phone: "03 552 4003",
        type: "fast"
        },
        {
        position: { lat: 32.39086379838782,  lng: 36.20536702593927 },
        title: 'Total gas station',
        info: 'المفرق',
        rating: 4.2,
        hours: "24/7",
        phone: "0779444427",
        type: "fast"
        },
    {
        position: { lat: 31.185456, lng: 35.704567 },
        title: 'محطة شحن الكرك',
        info: 'شارع الملك عبدالله الثاني',
        rating: 5,
        hours: "24/7",
        phone: "03 552 4003",
        type: "fast"
    },
    {
        position: { lat: 31.716543, lng: 35.793456 },
        title: 'محطة شحن مادبا',
        info: 'شارع الخليج',
        rating: 3,
        hours: "8:00 AM - 10:00 PM",
        phone: "05 552 4004",
        type: "standard"
    },
    {
        position: { lat: 32.039456, lng: 35.727345 },
        title: 'محطة شحن السلط',
        info: 'شارع الحمام',
        rating: 4,
        hours: "6:00 AM - 12:00 AM",
        phone: "05 552 4005",
        type: "standard"
    },
    {
        position: { lat: 32.052469, lng: 35.784541 },
        title: 'محطة شحن Ryalat',
        info: 'شارع السرو',
        rating: 5,
        hours: "24/7",
        phone: "06 552 4006",
        type: "fast"
    },
    {
        position: { lat: 31.870000, lng: 36.010000 },
        title: 'محطة شحن سحاب',
        info: 'المنطقة الصناعية',
        rating: 3,
        hours: "8:00 AM - 10:00 PM",
        phone: "06 552 4007",
        type: "standard"
    },
    {
        position: { lat: 31.910000, lng: 35.820000 },
        title: 'محطة شحن ناعور',
        info: 'شارع ناعور الرئيسي',
        rating: 4,
        hours: "6:00 AM - 11:00 PM",
        phone: "06 552 4008",
        type: "standard"
    },
    {
        position: { lat: 31.950000, lng: 35.820000 },
        title: 'محطة شحن وادي السير',
        info: 'شارع وادي السير الرئيسي',
        rating: 5,
        hours: "24/7",
        phone: "06 552 4009",
        type: "fast"
    },
    {
        position: { lat: 32.098765, lng: 36.123456 },
        title: 'محطة شحن الرصيفة الجديدة',
        info: 'شارع الرصيفة الجديدة',
        rating: 3,
        hours: "8:00 AM - 10:00 PM",
        phone: "06 552 4010",
        type: "standard"
    }
];
    
            locations.forEach(function (loc) {
                const distance = getDistance(userLat, userLng, loc.position.lat, loc.position.lng);
                if (distance <= maxDistance) {
                    const marker = new google.maps.Marker({
                        position: loc.position,
                        title: loc.title,
                        map: map,
                    });
    
                    // Create link for Google Maps directions
                    const directionsLink = `https://www.google.com/maps/dir/?api=1&origin=${userLat},${userLng}&destination=${loc.position.lat},${loc.position.lng}`;
    
                    const infoWindow = new google.maps.InfoWindow({
                        content: `
                            <div style="direction: rtl; text-align: right; min-width: 200px;">
                                <h4 style="margin-bottom: 5px;">${loc.title}</h4>
                                <p style="margin: 5px 0;"><i class="fas fa-map-marker-alt"></i> ${loc.info}</p>
                                <p><i class="fas fa-road"></i> Distance: ${distance.toFixed(1)} Km</p>
                                <p style="margin: 5px 0;"><i class="fas fa-clock"></i> ${loc.hours || 'Not available'}</p>
                                <p style="margin: 5px 0;"><i class="fas fa-phone"></i> ${loc.phone || 'Not available'}</p>
                                <div style="color: gold; margin: 5px 0;">
                                    ${'★'.repeat(loc.rating || 3)}${'☆'.repeat(5 - (loc.rating || 3))}
                                </div>
                                <a href="${directionsLink}"  
                                    style="display: block; background: #4285F4; color: white; 
                                    text-align: center; padding: 5px; border-radius: 4px; margin-top: 10px;">
                                    Get Directions
                                </a>
                            </div>
                        `
                    });
    
                    marker.addListener('click', function () {
                        infoWindow.open(map, marker);
                    });
                    markers.push(marker); // Add marker to array  
                }
            });
        }
    
        // Function to calculate distance between two points
        function getDistance(lat1, lon1, lat2, lon2) {
            const R = 6371; // Earth radius in km
            const dLat = (lat2 - lat1) * (Math.PI / 180);
            const dLon = (lon2 - lon1) * (Math.PI / 180);
            const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * (Math.PI / 180)) * Math.cos(lat2 * (Math.PI / 180)) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            const distance = R * c; // Distance in km
            return distance;
        }
    </script>
</x-app-layout>