Buatkan aku website lelang dengan template 3D darkmode 
menggunakan framework codeigniter 3

Landing Page Utama menampilkan sketsa berikut
- header
    - Logo Website
    - Menu 
        - Home
            - menampilkan halaman utama
        - About
            - menampilkan halaman about
        - Event
            - menampilkan halaman list event
        - Contact US
            - menampilkan kontak penyelenggara
    - Login / Reset Password / Daftar
        - POP UP Login / Reset Password / Daftar

- Body
    - Corousel Gambar, ketika di klik akan menuju kehalaman detail EVENT
    - list lelang
        - apabila ada lelang, akan menampilkan list card lelang (gambar, nama barang, harga barang, waktu lelang(detik berjalan), ketika di klik akan menampilkan detail barang, komponen inputan harga bid dan action bid akan muncul ketika sudah login
        - apabila tidak ada lelang, akan menampilkan card "event lelang belum tersedia"

- Footer
    - simple, hanya menampilkan nama website


Skema lelang : 
admin
- set event lelang
- menentukan batas pengumpulan barang lelang
- barang lelang sudah terkumpul, admin cek kelayakan barang lelang (layak => lanjut, ga layak => reject)
- start lelang
- lelang selesai => generate invoice ke bidders
- bidders sudah membayar => bidders upload bukti pembayaran => admin verifikasi => notif ke titipers untuk mengirim barang ke bidders
- titipers upload bukti pengiriman => admin verifikasi => pencairan uang ke titipers

titipers
- meng-upload foto dan deskripsi barang-barangnya sendiri
- saat ada event lelang => dia memilih barang-barangnya untuk di submit ke event lelang itu
- barang yg disetujui admin akan ikut dilelang
- barang yg tidak disetujui admin (benerin, terus menunggu verifikasi admin lagi)
- menunggu notif dari admin untuk pengiriman barang ke bidders
- mengupload bukti pengiriman barang
- menunggu pencairan uang dari admin

bidders
- mengikuti event lelang
- melalukan bid 
- mendapat invoice barang yang terpilih
- membayar invoice + mengupload invoice
- menerima barang