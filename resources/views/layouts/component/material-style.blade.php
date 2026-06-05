<link href="{{ asset('material/css/nucleo-icons.css') }}" rel="stylesheet" />
<link href="{{ asset('material/css/nucleo-svg.css') }}" rel="stylesheet" />
<script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
<link rel="stylesheet" id="css-main" href="{{ asset('material/css/material-dashboard-full.min.css') }}">

<style>
/* Wrapper selection */
/* ============================
   SELECT2 CUSTOM DESIGN
   ============================ */
/* FIX border agar tidak double */
/* ============================================
   RESET BORDER DEFAULT SELECT2 (WAJIB)
   ============================================ */
/* ============================================
   RESET BAWAAN SELECT2
   ============================================ */
.select2-container .select2-selection--single {
    background: transparent !important;
    border: none !important;
    height: 38px !important; /* tinggi input */
    display: flex !important;
    align-items: center !important;
}

.select2-container .select2-selection__rendered {
    line-height: 1.2 !important;
    margin: 0 !important;
    padding-left: 0 !important;
    padding-right: 28px !important; /* ruang untuk arrow */
}

.select2-container .select2-selection__arrow {
    height: 100% !important;
}

/* ============================================
   BORDER CUSTOM (TIPIS 1PX)
   ============================================ */
.select2-container--default .select2-selection--single {
    border: 1px solid #d2d6da !important;
    border-radius: 8px !important;
    background: #fff !important;

    padding: 4px 10px !important;
    box-shadow: none !important;
}

.select2-container--default .select2-selection--single:hover {
    border-color: #a3a3a3 !important;
}

/* Placeholder */
.select2-container--default .select2-selection__placeholder {
    color: #9ca3af !important;
    line-height: 1.2 !important;
}

/* Selected text */
.select2-container--default .select2-selection__rendered {
    color: #111827 !important;
    font-size: 14px !important;
}

/* ============================================
   ARROW (POSISI BENAR-BENAR DI TENGAH)
   ============================================ */
.select2-container .select2-selection__arrow {
    position: absolute !important;
    top: 45% !important;
    right: 10px !important;
    transform: translateY(-50%) !important;

    width: 16px !important;
    height: 16px !important;

    display: flex !important;
    align-items: center !important;
    justify-content: center !important;

    pointer-events: none !important;
}

.select2-container .select2-selection__arrow b {
    border-width: 5px 4px 0 4px !important;
    margin: 0 !important;
}

/* ============================================
   DROPDOWN
   ============================================ */
.select2-container--default .select2-dropdown {
    border: 1px solid #d2d6da !important;
    border-radius: 8px !important;
    padding: 4px 0 !important;
    background: #fff !important;
}

/* List container */
.select2-results__options {
    max-height: 200px !important;
    padding: 0 !important;
}

/* Item dropdown (lebih ramping) */
.select2-results__option {
    padding: 6px 10px !important;
    margin: 0 !important;
    font-size: 14px !important;
    line-height: 1.3 !important;
    border-radius: 4px !important;
}

/* Hover */
.select2-results__option--highlighted {
    background: #4f46e5 !important;
    color: #fff !important;
}

/* Selected */
.select2-results__option--selected {
    background: #d2d6da !important;
    color: #111 !important;
}




</style>
