<?php 
include "header.php"; 
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center p-3 bg-dark text-white rounded mb-4">
        <span class="fs-5 fw-bold">Kontak Kami</span>
    </div>

    <div class="row">
        <!-- Kolom Kiri (Informasi Kontak) -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-dark text-white">Informasi Kontak</div>
                <div class="card-body">
                    <h5 class="card-title fw-bold text-dark">Klinik Pratama Bhakti Asih</h5>
                    <p class="text-secondary">
                        Komitmen bagi Layanan Terakreditasi. Sejak awal pengoperasiannya, 
                        Klinik Pratama Bhakti Asih berkomitmen sebagai penyedia layanan pasien 
                        BPJS untuk menunjang program pemerintah Indonesia, serta bersegera memenuhi 
                        akreditasi KARS (Komite Akreditasi Rumah Sakit) guna mencapai predikat "Paripurna".
                    </p>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan (Google Maps) -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-dark text-white">Lokasi Kami</div>
                <div class="card-body p-0">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.128035743961!2d106.6994488!3d-6.2326102!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69fa1797beb219%3A0xa9cb1662243f2a67!2sKlinik%20Bhakti%20Asih!5e0!3m2!1sid!2sid!4v1618200000000!5m2!1sid!2sid"
                        width="100%" 
                        height="300" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include "footer.php"; 
?>
