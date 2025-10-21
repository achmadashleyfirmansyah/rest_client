<?php
/**
 * White Box Testing: API Connection & Response Validation
 * File: system-test.php
 * Tujuan: Memastikan koneksi ke Spoonacular API berhasil dan data dapat di-decode.
 */

// Konfigurasi API
$apiKey = "dd151ab80819442d8cc006ae68f71933";
$endpoint = "https://api.spoonacular.com/recipes/random?number=1&apiKey={$apiKey}";

echo "<h3>System Test: REST Client PHP - Spoonacular API</h3>";

try {
    // --- STEP 1: Panggil API ---
    $response = @file_get_contents($endpoint);

    if ($response === FALSE) {
        throw new Exception("Gagal mengakses API endpoint.");
    }

    // --- STEP 2: Decode JSON ---
    $data = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Respon API bukan format JSON valid.");
    }

    // --- STEP 3: Validasi Struktur Data ---
    if (!isset($data['recipes'][0]['title'])) {
        throw new Exception("Struktur data tidak sesuai ekspektasi (tidak ada 'title').");
    }

    // --- STEP 4: Jika semua berhasil ---
    echo "<p style='color:green; font-weight:bold;'>PASS ✅ - API Spoonacular merespon dengan benar.</p>";
    echo "<p><b>Judul Resep:</b> " . htmlspecialchars($data['recipes'][0]['title']) . "</p>";

} catch (Exception $e) {
    // --- Tangani Error ---
    echo "<p style='color:red; font-weight:bold;'>FAIL ❌ - " . $e->getMessage() . "</p>";
}
?>
