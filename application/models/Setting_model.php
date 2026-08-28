<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_model extends CI_Model {

    private $table = 'settings';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get($key)
    {
        $query = $this->db->where('setting_key', $key)->get($this->table);
        if ($query->num_rows() === 1)
        {
            $row = $query->row_array();
            return $row['setting_value'];
        }
        return NULL;
    }

    public function get_many($keys)
    {
        $result = array();
        foreach ($keys as $key)
        {
            $result[$key] = $this->get($key);
        }
        return $result;
    }

    public function get_all($group = NULL)
    {
        if ($group !== NULL)
        {
            $this->db->where('setting_group', $group);
        }
        $query = $this->db->get($this->table);
        $result = array();
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {
                $result[$row['setting_key']] = $row['setting_value'];
            }
        }
        return $result;
    }

    public function set($key, $value, $group = 'general')
    {
        $exists = $this->db->where('setting_key', $key)->count_all_results($this->table);

        if ($exists > 0)
        {
            $this->db->where('setting_key', $key);
            return $this->db->update($this->table, array('setting_value' => $value));
        }

        return $this->db->insert($this->table, array(
            'setting_key'   => $key,
            'setting_value' => $value,
            'setting_group' => $group
        ));
    }

    public function update_many($data, $group = 'general')
    {
        $success = TRUE;
        foreach ($data as $key => $value)
        {
            if (!$this->set($key, $value, $group))
            {
                $success = FALSE;
            }
        }
        return $success;
    }

    public function seed_defaults()
    {
        $defaults = $this->default_settings();
        foreach ($defaults as $key => $value)
        {
            $group = strtok($key, '_');
            $this->set($key, $value, $group);
        }
    }

    public function default_settings()
    {
        return array(
            'home_hero_title_accent' => 'Temukan',
            'home_hero_title' => 'Barang Langka Terbaik di',
            'home_hero_highlight' => 'Omera Auction',
            'home_hero_subtitle' => 'Platform lelang online terpercaya yang menghubungkan Titipers (penjual) dengan Bidders (pembeli). Temukan barang unik dan langka dengan harga terbaik melalui sistem lelang yang transparan dan aman.',
            'home_hero_btn_primary' => 'Mulai Lelang',
            'home_hero_btn_secondary' => 'Pelajari Lebih Lanjut',
            'home_stat_event_label' => 'Event Aktif',
            'home_stat_item_label' => 'Total Barang',
            'home_stat_bidder_label' => 'Bidders',
            'home_carousel_title' => 'Event Terbaru',
            'home_carousel_subtitle' => 'Jangan lewatkan event lelang menarik dari kami',
            'home_active_title' => 'Lelang Aktif',
            'home_active_subtitle' => 'Barang-barang yang sedang dilelang secara langsung',
            'home_empty_title' => 'Event Lelang Belum Tersedia',
            'home_empty_message' => 'Saat ini belum ada event lelang yang sedang berlangsung. Silakan cek kembali nanti atau lihat event yang akan datang.',
            'home_empty_btn' => 'Lihat Semua Event',

            'about_hero_title' => 'About Us',
            'about_hero_subtitle' => 'Mengenal lebih dekat platform lelang Omera Auction',
            'about_apa_title' => 'Apa itu Omera Auction?',
            'about_apa_brand' => 'Omera Auction',
            'about_desc1' => 'Omera Auction adalah platform lelang online yang menghubungkan Titipers (penjual) dengan Bidders (pembeli) dalam suasana lelang yang transparan, mudah, dan terpercaya. Kami menyediakan wadah bagi siapa saja yang ingin menjual atau membeli barang langka dan unik melalui sistem lelang digital yang profesional.',
            'about_desc2' => 'Dengan dukungan Admin yang mengelola setiap proses lelang, mulai dari verifikasi barang, pengelolaan event, hingga pemrosesan pembayaran dan pengiriman, Omera Auction memastikan setiap transaksi berjalan aman dan fair untuk semua pihak.',
            'about_features_title' => 'Mengapa Memilih Omera Auction?',
            'about_features_subtitle' => 'Keunggulan yang kami tawarkan',
            'about_feature1_title' => 'Lelang Transparan',
            'about_feature1_desc' => 'Setiap proses lelang dapat dipantau secara real-time. Harga bid, jumlah peserta, dan status lelang ditampilkan secara terbuka sehingga semua peserta mendapat informasi yang adil.',
            'about_feature2_title' => 'Proses Mudah',
            'about_feature2_desc' => 'Mendaftar, mengajukan barang, hingga melakukan penawaran semuanya dapat dilakukan dengan mudah melalui platform kami. Antarmuka yang intuitif membuat pengalaman lelang menyenangkan.',
            'about_feature3_title' => 'Aman & Terpercaya',
            'about_feature3_desc' => 'Transaksi diproses melalui sistem yang aman. Pembayaran, verifikasi, pengiriman, hingga pencairan dana dikelola oleh admin untuk menjamin keamanan setiap transaksi.',
            'about_workflow_title' => 'Bagaimana Cara Kerjanya?',
            'about_workflow_subtitle' => 'Alur proses lelang di Omera Auction',
            'about_workflow1_title' => 'Daftar Akun',
            'about_workflow1_desc' => 'Daftar sebagai Titipers (penjual) atau Bidders (pembeli) dan lengkapi profil Anda.',
            'about_workflow2_title' => 'Ajukan Barang',
            'about_workflow2_desc' => 'Titipers mengajukan barang ke event lelang yang tersedia. Admin akan memverifikasi setiap barang.',
            'about_workflow3_title' => 'Lelang Dimulai',
            'about_workflow3_desc' => 'Bidders memberikan penawaran (bid) secara real-time saat event lelang aktif berlangsung.',
            'about_workflow4_title' => 'Menang & Bayar',
            'about_workflow4_desc' => 'Bidder tertinggi memenangkan lelang, melakukan pembayaran, dan barang dikirim oleh Titipers.',
            'about_roles_title' => 'Peran Pengguna',
            'about_roles_subtitle' => 'Tiga peran utama dalam ekosistem Omera Auction',
            'about_role1_title' => 'Titipers',
            'about_role1_desc' => 'Penjual yang mengajukan barang untuk dilelang. Barang yang diajukan akan diverifikasi oleh admin sebelum masuk ke event lelang.',
            'about_role1_feat1' => 'Ajukan barang ke event',
            'about_role1_feat2' => 'Pantau status barang',
            'about_role1_feat3' => 'Proses pengiriman',
            'about_role2_title' => 'Bidders',
            'about_role2_desc' => 'Pembeli yang berpartisipasi dalam lelang dengan memberikan penawaran harga untuk barang yang diinginkan.',
            'about_role2_feat1' => 'Ikut lelang barang',
            'about_role2_feat2' => 'Bid secara real-time',
            'about_role2_feat3' => 'Bayar & terima barang',
            'about_role3_title' => 'Admin',
            'about_role3_desc' => 'Pengelola platform yang mengawasi seluruh proses lelang dari awal hingga akhir.',
            'about_role3_feat1' => 'Kelola event & barang',
            'about_role3_feat2' => 'Verifikasi pembayaran',
            'about_role3_feat3' => 'Proses pencairan dana',

            'contact_hero_title' => 'Contact Us',
            'contact_hero_subtitle' => 'Hubungi kami untuk pertanyaan, saran, atau kerja sama',
            'contact_form_title' => 'Kirim Pesan',
            'contact_form_name_label' => 'Nama Lengkap',
            'contact_form_name_placeholder' => 'Masukkan nama lengkap',
            'contact_form_email_label' => 'Email',
            'contact_form_email_placeholder' => 'Masukkan email',
            'contact_form_subject_label' => 'Subjek',
            'contact_form_subject_placeholder' => 'Masukkan subjek',
            'contact_form_message_label' => 'Pesan',
            'contact_form_message_placeholder' => 'Tuliskan pesan Anda...',
            'contact_form_submit' => 'Kirim Pesan',
            'contact_info_title' => 'Informasi Kontak',
            'contact_address_title' => 'Alamat',
            'contact_address' => "Jl. Contoh No. 123\nJakarta, Indonesia",
            'contact_email_title' => 'Email',
            'contact_email' => 'info@omera-auction.com',
            'contact_phone_title' => 'Telepon',
            'contact_phone' => '+62 xxx xxxx xxxx',
            'contact_social_title' => 'Ikuti Kami',
            'contact_footer_text' => '',
        );
    }
}
