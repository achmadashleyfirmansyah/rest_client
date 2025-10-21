<?php
/**
 * White Box Testing: REST Client PHP - Spoonacular API
 * File: system-test-whitebox.php
 * Tujuan: Menguji koneksi, validasi format JSON, dan struktur data API.
 */

$apiKey = "dd151ab80819442d8cc006ae68f71933";
$endpoint = "https://api.spoonacular.com/recipes/random?number=1&apiKey={$apiKey}";

echo "<h2>White Box Testing: REST Client PHP - Spoonacular API</h2>";

/**
 * Test Case 1: Validasi koneksi API (HTTP response)
 */
try {
    $response = @file_get_contents($endpoint);
    if ($response === FALSE) {
        throw new Exception("Gagal mengakses API endpoint.");
    }
    echo "<p style='color:green;'>[PASS ✅] Test Case 1: Koneksi API berhasil.</p>";
} catch (Exception $e) {
    echo "<p style='color:red;'>[FAIL ❌] Test Case 1: " . $e->getMessage() . "</p>";
}

/**
 * Test Case 2: Validasi format JSON (parsing)
 */
try {
    $response = @file_get_contents($endpoint);
    $data = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Respon API bukan format JSON valid.");
    }
    echo "<p style='color:green;'>[PASS ✅] Test Case 2: Respon API JSON valid.</p>";
} catch (Exception $e) {
    echo "<p style='color:red;'>[FAIL ❌] Test Case 2: " . $e->getMessage() . "</p>";
}

/**
 * Test Case 3: Validasi struktur data JSON (cek field penting)
 */
try {
    $response = @file_get_contents($endpoint);
    $data = json_decode($response, true);

    if (!isset($data['recipes'][0]['id']) || !isset($data['recipes'][0]['title'])) {
        throw new Exception("Struktur data tidak sesuai ekspektasi (id/title tidak ditemukan).");
    }

    echo "<p style='color:green;'>[PASS ✅] Test Case 3: Struktur data API sesuai ekspektasi.</p>";
} catch (Exception $e) {
    echo "<p style='color:red;'>[FAIL ❌] Test Case 3: " . $e->getMessage() . "</p>";
}
?>
