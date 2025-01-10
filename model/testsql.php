<?php
// Pastikan semua file terkait model dan koneksi database sudah di-include
include_once "/laragon/www/project_akhir/model/dbConnect.php";
include_once "/laragon/www/project_akhir/model/modelMemberSql.php";

// Inisialisasi model member
$modelMember = new modelMember();

// Menampilkan semua member saat ini
echo "<h3>Data Awal:</h3>";
displayAllMembers($modelMember);

// 1. Menambahkan member baru
// echo "<h3>Menambahkan Member Baru:</h3>";
// $newMemberName = "Test User";
// $newMemberPassword = "testpassword";
// $newMemberPhone = "0811223344";
// $newMemberPoint = 500;

// if ($modelMember->addMember($newMemberName, $newMemberPassword, $newMemberPhone, $newMemberPoint)) {
//     echo "Member berhasil ditambahkan!<br>";
// } else {
//     echo "Gagal menambahkan member.<br>";
// }
displayAllMembers($modelMember);

// 2. Mengupdate member yang sudah ada
echo "<h3>Mengupdate Member:</h3>";
$updateMemberId = 1; // ID member yang akan diupdate (pastikan ID ini ada)
$updatedName = "Updated Name";
$updatedPassword = "newpassword123";
$updatedPhone = "0811556677";
$updatedPoint = 1000;

if ($modelMember->updateMember($updateMemberId, $updatedName, $updatedPassword, $updatedPhone, $updatedPoint)) {
    echo "Member dengan ID $updateMemberId berhasil diupdate!<br>";
} else {
    echo "Gagal mengupdate member dengan ID $updateMemberId.<br>";
}
displayAllMembers($modelMember);

// 3. Mengambil detail member berdasarkan ID
echo "<h3>Detail Member Berdasarkan ID:</h3>";
$searchMemberId = 1; // ID yang ingin dicari
$member = $modelMember->getMemberById($searchMemberId);

if ($member) {
    echo "ID: " . htmlspecialchars($member->id) . "<br>";
    echo "Name: " . htmlspecialchars($member->name) . "<br>";
    echo "Password: " . htmlspecialchars($member->password) . "<br>";
    echo "Phone: " . htmlspecialchars($member->phone) . "<br>";
    echo "Point: " . htmlspecialchars($member->point) . "<br>";
} else {
    echo "Member dengan ID $searchMemberId tidak ditemukan.<br>";
}

// 4. Menghapus member berdasarkan ID
echo "<h3>Menghapus Member:</h3>";
$deleteMemberId = 1; // ID member yang ingin dihapus
if ($modelMember->deleteMember($deleteMemberId)) {
    echo "Member dengan ID $deleteMemberId berhasil dihapus!<br>";
} else {
    echo "Gagal menghapus member dengan ID $deleteMemberId.<br>";
}
displayAllMembers($modelMember);

// Fungsi untuk menampilkan semua member
function displayAllMembers($modelMember) {
    $members = $modelMember->getAllMembers();

    if ($members === null || empty($members)) {
        echo "Tidak ada member ditemukan.<br>";
        return;
    }

    foreach ($members as $member) {
        echo "ID: " . htmlspecialchars($member->id) . "<br>";
        echo "Name: " . htmlspecialchars($member->name) . "<br>";
        echo "Password: " . htmlspecialchars($member->password) . "<br>";
        echo "Phone: " . htmlspecialchars($member->phone) . "<br>";
        echo "Point: " . htmlspecialchars($member->point) . "<br>";
        echo "-----------------------<br>";
    }
}
?>