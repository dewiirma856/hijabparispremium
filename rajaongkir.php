

<?php
// Masukkan API Key Anda dari RajaOngkir
$apiKey = "59e94f93d1d5597310e8d00e1f5ecf93"; 

// Inisialisasi cURL
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.rajaongkir.com/starter/city",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => 2,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "key: $apiKey"
    ),
));

// Eksekusi permintaan
$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    // Parsing JSON ke dalam array PHP
    $data = json_decode($response, true);

    // Cek apakah data berhasil diambil
    if (isset($data['rajaongkir']['results'])) {
        echo "<h1>Daftar Kota dan ID Kota RajaOngkir</h1>";
        echo "<table border='1' cellpadding='10' cellspacing='0'>";
        echo "<tr>
                <th>City ID</th>
                <th>Province</th>
                <th>City Name</th>
                <th>Type</th>
                <th>Postal Code</th>
              </tr>";

        foreach ($data['rajaongkir']['results'] as $city) {
            echo "<tr>
                    <td>" . $city['city_id'] . "</td>
                    <td>" . $city['province'] . "</td>
                    <td>" . $city['city_name'] . "</td>
                    <td>" . $city['type'] . "</td>
                    <td>" . $city['postal_code'] . "</td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "Gagal mendapatkan data kota dari RajaOngkir.";
    }
}
?>