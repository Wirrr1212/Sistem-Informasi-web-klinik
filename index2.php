<?php 
  include "header.php"; 
?>

<main>
  <div id="carouselExampleControlsNoTouching" class="carousel slide" data-bs-ride="carousel" data-bs-touch="false">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="assets/Tampilan/Beranda1.png" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="assets/Tampilan/Beranda3.png" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="assets/Tampilan/beranda2.png" class="d-block w-100" alt="...">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <div class="container marketing">
  
    <div class="">
  <div class="col-md-7">
    <h2 class="featurette-heading">
      <a href="#" class="text-decoration-none text-dark">
        Kepuasan Anda Adalah Prioritas Kami
      </a>
    </h2>
    <p><a href="VM.php" class="btn btn-primary">Tentang Klinik Pratama Bhakti Asih &raquo;</a></p>
  </div>
</div>

<hr class="featurette-divider">
<div class="container mt-5">
    <div class="row justify-content-end text-end"> 
        <div class="col-md-5 text-start ms-auto pe-5"> 
            <h5 class="fw-bold text-dark">Klinik Pratama Bhakti Asih</h5>
            <h2 class="fw-bold"><span class="bg-primary px-2"> </span> Tentang Kami</h2>
            <p class="fs-5 text-secondary">VISI dan MISI Klinik Pratama Bhakti Asih</p>

            <p class="fw-bold text-dark">VISI</p>
            <p class="text-dark">Menjadi Klinik yang mampu memberikan pelayanan Kesehatan terbaik, bermutu dan terintegrasi
                di provinsi Banten pada tahun 2027.</p>

            <p class="fw-bold text-dark">MISI</p>
            <ol class="text-dark">
                <li>Mengembangkan Sumber Daya Manusia klinik yang kompeten, profesional, dan berintegrasi.</li>
                <li>Mewujudkan klinik yang mampu berdaya saing dan mampu beradaptasi dengan kemajuan ilmu pengetahuan dan teknologi.</li>
                <li>Mengembangkan pelayanan kesehatan yang komprehensif mulai dari promosi, preventif, dan kuratif.</li>
                <li>Mengembangkan pengelolaan keuangan yang profesional, transparan, efektif, dan efisien.</li>
            </ol>
        </div>
    </div>
</div>

    <hr class="featurette-divider">
    <div class="row featurette">
  <div class="col-md-7">
    <h2 class="featurette-heading">
      <a href="berita.php?id=2" class="text-decoration-none text-dark">
        GERD: Penyakit Asam Lambung yang Perlu Diwaspadai
      </a>
    </h2>
    <p class="lead">GERD adalah kondisi kronis yang terjadi ketika asam lambung naik kembali ke kerongkongan...</p>
    <p><a href="berita.php?id=2" class="btn btn-primary">Baca Selengkapnya &raquo;</a></p>
  </div>
  <div class="col-md-5">
    <a href="berita.php?id=2">
      <img src="assets/Tampilan/GERD.png" class="img-fluid mx-auto" alt="GERD" width="500" height="500">
    </a>
  </div>
</div>
  </div>
</main>
<hr class="featurette-divider">

<?php 
  include "footer.php"; 
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    let myCarousel = new bootstrap.Carousel(document.querySelector("#carouselExampleControlsNoTouching"), {
      interval: 3000,
      ride: "carousel",
      pause: false,
      wrap: true
    });
  });
</script>
