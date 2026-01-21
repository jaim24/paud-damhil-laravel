# API Documentation - PAUD Damhil Absensi

Dokumentasi API untuk aplikasi Flutter Absensi Guru PAUD Damhil.

**Base URL Production**: `https://yourdomain.com/api`  
**Base URL Development**: `http://localhost:8000/api`

---

## Authentication

API menggunakan **Laravel Sanctum** dengan Bearer Token.

```
Authorization: Bearer <your_token>
```

Token didapat dari response login dan harus disertakan di header untuk semua endpoint yang memerlukan autentikasi (ditandai 🔒).

---

## Endpoints

### 1. Login

**POST** `/login`

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| nip | string | ✅ | Nomor Induk Pegawai |
| password | string | ✅ | Password guru |

**Response Success (200):**

```json
{
  "success": true,
  "message": "Login berhasil",
  "data": {
    "token": "1|abc123...",
    "teacher": {
      "id": 1,
      "nip": "198501012010011001",
      "name": "Ahmad Suparjo",
      "position": "Guru Kelas",
      "phone": "081234567890",
      "email": "ahmad@paud.sch.id",
      "photo": "https://yourdomain.com/storage/photos/ahmad.jpg"
    }
  }
}
```

**Response Error (401):**

```json
{
  "success": false,
  "message": "Password salah"
}
```

---

### 2. Forgot Password

**POST** `/forgot-password`

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| nip | string | ❌ | NIP (salah satu wajib) |
| email | string | ❌ | Email (salah satu wajib) |

**Response (200):**

```json
{
  "success": true,
  "message": "Permintaan terkirim ke Admin."
}
```

---

### 3. Get Settings

**GET** `/settings`

Mengambil konfigurasi sekolah untuk geofencing.

**Response (200):**

```json
{
  "success": true,
  "data": {
    "school_latitude": 0.5439,
    "school_longitude": 123.0568,
    "max_distance": 100,
    "work_start_time": "07:00",
    "work_end_time": "14:00"
  }
}
```

---

### 4. Get Profile 🔒

**GET** `/profile`

**Response (200):**

```json
{
  "success": true,
  "data": {
    "id": 1,
    "nip": "198501012010011001",
    "name": "Ahmad Suparjo",
    "position": "Guru Kelas",
    "phone": "081234567890",
    "email": "ahmad@paud.sch.id",
    "photo": "https://yourdomain.com/storage/photos/ahmad.jpg",
    "stats": {
      "hadir": 20,
      "izin": 1,
      "sakit": 0,
      "terlambat": 2,
      "tanpa_keterangan": 0
    }
  }
}
```

---

### 5. Logout 🔒

**POST** `/logout`

**Response (200):**

```json
{
  "success": true,
  "message": "Logout berhasil"
}
```

---

### 6. Submit Attendance 🔒

**POST** `/absensi`

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| type | string | ✅ | `masuk` atau `pulang` |
| latitude | number | ✅ | Latitude lokasi saat absen |
| longitude | number | ✅ | Longitude lokasi saat absen |

**Response Success (200):**

```json
{
  "success": true,
  "message": "Berhasil absen masuk"
}
```

**Response Error (400):**

```json
{
  "success": false,
  "message": "Anda berada di luar radius (150m). Maksimal: 100m"
}
```

---

### 7. Today Status 🔒

**GET** `/absensi/today`

**Response (200):**

```json
{
  "success": true,
  "data": {
    "has_checked_in": true,
    "has_checked_out": false,
    "check_in_time": "07:15:00",
    "check_out_time": null,
    "status": "hadir",
    "date": "2026-01-21"
  }
}
```

---

### 8. Attendance History 🔒

**GET** `/absensi/history`

| Param | Type | Required | Description |
|-------|------|----------|-------------|
| month | int | ❌ | Bulan (1-12), default: bulan ini |
| year | int | ❌ | Tahun, default: tahun ini |

**Response (200):**

```json
{
  "success": true,
  "data": [
    {
      "date": "2026-01-21",
      "time": "07:15",
      "type": "masuk",
      "status": "hadir",
      "is_late": false
    },
    {
      "date": "2026-01-20",
      "time": "14:05",
      "type": "pulang",
      "status": "hadir",
      "is_late": false
    }
  ]
}
```

---

### 9. Submit Leave 🔒

**POST** `/izin`

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| date | date | ✅ | Tanggal izin (YYYY-MM-DD) |
| type | string | ✅ | `izin` atau `sakit` |
| reason | string | ✅ | Alasan (max 500 karakter) |

**Response (200):**

```json
{
  "success": true,
  "message": "Pengajuan Izin berhasil dikirim",
  "data": {
    "id": 5,
    "date": "2026-01-22",
    "type": "izin",
    "reason": "Acara keluarga",
    "status": "pending"
  }
}
```

---

### 10. Leave History 🔒

**GET** `/izin/history`

**Response (200):**

```json
{
  "success": true,
  "data": [
    {
      "id": 5,
      "date": "2026-01-22",
      "type": "izin",
      "reason": "Acara keluarga",
      "status": "approved",
      "rejection_reason": null,
      "created_at": "2026-01-21 08:00"
    }
  ]
}
```

---

## Status Codes

| Code | Description |
|------|-------------|
| 200 | Success |
| 400 | Bad Request (validation error) |
| 401 | Unauthorized (wrong password/invalid token) |
| 404 | Not Found |
| 500 | Server Error |

---

## Flutter Integration Example

```dart
// lib/services/api_service.dart
import 'package:http/http.dart' as http;
import 'dart:convert';

class ApiService {
  static const String baseUrl = 'https://yourdomain.com/api';
  String? _token;

  Future<Map<String, dynamic>> login(String nip, String password) async {
    final response = await http.post(
      Uri.parse('$baseUrl/login'),
      headers: {'Content-Type': 'application/json'},
      body: jsonEncode({'nip': nip, 'password': password}),
    );
    
    final data = jsonDecode(response.body);
    if (data['success']) {
      _token = data['data']['token'];
    }
    return data;
  }

  Future<Map<String, dynamic>> getTodayStatus() async {
    final response = await http.get(
      Uri.parse('$baseUrl/absensi/today'),
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer $_token',
      },
    );
    return jsonDecode(response.body);
  }
}
```
