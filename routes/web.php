<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\BotManController;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'index'])->middleware('haslogin');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->middleware('throttle:60,1');
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);
Route::get('/dashboard', function (Request $request) {
    $nama = $request->session()->get('nama');
    return view('dashboard',['nama' => $nama]);
})->middleware('ceklogin');

Route::get('dahboard-renstra', fn() => view('dashboard.renstra'))->middleware('ceklogin');

Route::middleware(['ceklogin'])->prefix('renstra')->group(function () {
    Route::get('dokpol', fn() => view('renstra.dokpol'))->named('renstra.dokpol');
    Route::get('sdm', fn() => view('renstra.sdm'))->named('renstra.sdm');
    Route::get('pelayanan', fn() => view('renstra.pelayanan'))->named('renstra.pelayanan');
});

Route::middleware(['ceklogin'])->prefix('sdm')->group(function () {

    Route::get('/perawat', fn() => view('sdm.perawat'))->named('perawat');
    Route::post('/perawat/kirim', [App\Http\Controllers\SDM\PerawatController::class, 'store']);

    Route::get('/bidan', fn() => view('sdm.bidan'))->named('bidan');
    Route::post('/bidan/kirim', [App\Http\Controllers\SDM\BidanController::class, 'store']);

    Route::get('/laboratorium', fn() => view('sdm.laboratorium'))->named('laboratorium');
    Route::post('/laboratorium/kirim', [App\Http\Controllers\SDM\LaboratoriumController::class, 'store']);

    Route::get('/nutritionist', fn() => view('sdm.nutritionist'))->named('nutritionist');
    Route::post('/nutritionist/kirim', [App\Http\Controllers\SDM\NutritionistController::class, 'store']);

    Route::get('/radiographer', fn() => view('sdm.radiographer'))->named('radiographer');
    Route::post('/radiographer/kirim', [App\Http\Controllers\SDM\RadiographerController::class, 'store']);

    Route::get('/pharmacist', fn() => view('sdm.pharmacist'))->named('pharmacist');
    Route::post('/pharmacist/kirim', [App\Http\Controllers\SDM\PharmacistController::class, 'store']);

    Route::get('/profesionallainnya', fn() => view('sdm.profesionallainnya'))->named('profesionallainnya');
    Route::post('/profesionallainnya/kirim', [App\Http\Controllers\SDM\ProfessionalLainnyaController::class, 'store']);

    Route::get('/nonmedis', fn() => view('sdm.nonmedis'))->named('nonmedis');
    Route::post('/nonmedis/kirim', [App\Http\Controllers\SDM\NonMedisController::class, 'store']);

    Route::get('/sanitarian', fn() => view('sdm.sanitarian'))->named('sanitarian');
    Route::post('/sanitarian/kirim', [App\Http\Controllers\SDM\SanitarianController::class, 'store']);

    Route::get('/administrasi', fn() => view('sdm.administrasi'))->named('administrasi');
    Route::post('/administrasi/kirim', [App\Http\Controllers\SDM\AdministrasiController::class, 'store']);

    Route::get('/spesialis', fn() => view('sdm.spesialis'))->named('spesialis');
    Route::post('/spesialis/kirim', [App\Http\Controllers\SDM\SpesialisController::class, 'store']);

    Route::get('/doktergigi', fn() => view('sdm.doktergigi'))->named('doktergigi');
    Route::post('/doktergigi/kirim', [App\Http\Controllers\SDM\DokterGigiController::class, 'store']);

    Route::get('/dokterumum', fn() => view('sdm.dokterumum'))->named('dokterumum');
    Route::post('/dokterumum/kirim', [App\Http\Controllers\SDM\DokterUmumController::class, 'store']);

});

Route::middleware(['ceklogin'])->prefix('layanan')->group(function () {

    Route::get('/ikm', [App\Http\Controllers\Layanan\IKMController::class, 'index'])->named('ikm');
    Route::post('/ikm/kirim', [App\Http\Controllers\Layanan\IKMController::class, 'store']);

    Route::get('/laboratoriumsampel', [App\Http\Controllers\Layanan\LaboratoriumSampelController::class, 'index'])->named('laboratoriumsampel');
    Route::post('/laboratoriumsampel/kirim', [App\Http\Controllers\Layanan\LaboratoriumSampelController::class, 'store']);

    Route::get('/farmasi', [App\Http\Controllers\Layanan\FarmasiController::class, 'index']);
    Route::post('/farmasi/kirim', [App\Http\Controllers\Layanan\FarmasiController::class, 'store']);

    Route::get('/bor', [App\Http\Controllers\Layanan\BorController::class, 'index']);
    Route::post('/bor/kirim', [App\Http\Controllers\Layanan\BorController::class, 'store']);

    Route::get('/toi', [App\Http\Controllers\Layanan\ToiController::class, 'index']);
    Route::post('/toi/kirim', [App\Http\Controllers\Layanan\ToiController::class, 'store']);

    Route::get('/alos', [App\Http\Controllers\Layanan\AlosController::class, 'index']);
    Route::post('/alos/kirim', [App\Http\Controllers\Layanan\AlosController::class, 'store']);

    Route::get('/bto', [App\Http\Controllers\Layanan\BtoController::class, 'index']);
    Route::post('/bto/kirim', [App\Http\Controllers\Layanan\BtoController::class, 'store']);

    Route::get('/laboratoriumparameter', [App\Http\Controllers\Layanan\LaboratoriumParameterController::class, 'index'])->named('laboratorium.parameter');
    Route::post('/laboratoriumparameter/kirim', [App\Http\Controllers\Layanan\LaboratoriumParameterController::class, 'store']);

    Route::get('/igd', [App\Http\Controllers\Layanan\IGDController::class, 'index'])->named('igd');
    Route::post('/igd/kirim', [App\Http\Controllers\Layanan\IGDController::class, 'store']);

    Route::get('/operasi', [App\Http\Controllers\Layanan\OperasiController::class, 'index'])->named('operasi');
    Route::post('/operasi/kirim', [App\Http\Controllers\Layanan\OperasiController::class, 'store']);

    Route::get('/radiologi', [App\Http\Controllers\Layanan\RadiologiController::class, 'index'])->named('radiologi');
    Route::post('/radiologi/kirim', [App\Http\Controllers\Layanan\RadiologiController::class, 'store']);

    Route::get('/ralan', [App\Http\Controllers\Layanan\RalanController::class, 'index'])->named('ralan');
    Route::post('/ralan/kirim', [App\Http\Controllers\Layanan\RalanController::class, 'store']);

    Route::get('/ranap', [App\Http\Controllers\Layanan\RanapController::class, 'index'])->named('ranap');
    Route::post('/ranap/kirim', [App\Http\Controllers\Layanan\RanapController::class, 'store']);

    Route::get('/bpjs_non_bpjs', [App\Http\Controllers\Layanan\BPJSNonBPJSController::class, 'index'])->named('bpjs_non_bpjs');
    Route::post('/bpjs_non_bpjs/kirim', [App\Http\Controllers\Layanan\BPJSNonBPJSController::class, 'store']);

    Route::get('/poli', [App\Http\Controllers\Layanan\PoliController::class, 'index'])->named('poli');
    Route::post('/poli/kirim', [App\Http\Controllers\Layanan\PoliController::class, 'store']);

    Route::get('/forensik', [App\Http\Controllers\Layanan\ForensikController::class, 'index'])->named('forensik');
    Route::post('/forensik/kirim', [App\Http\Controllers\Layanan\ForensikController::class, 'store']);

    Route::get('/dokpol', [App\Http\Controllers\Layanan\DokpolController::class, 'index'])->named('dokpol');
    Route::post('/dokpol/kirim', [App\Http\Controllers\Layanan\DokpolController::class, 'store']);

});

Route::middleware(['ceklogin'])->prefix('keuangan')->group(function () {

    Route::get('/operasional', fn() => view('keuangan.operasional'))->named('operasional');
    // Route::get('/operasional', [App\Http\Controllers\Keuangan\OperasionalController::class, 'index'])->named('operasional');
    Route::post('/operasional/kirim', [App\Http\Controllers\Keuangan\OperasionalController::class, 'store']);

    Route::get('/kas', [App\Http\Controllers\Keuangan\KasController::class, 'index'])->named('kas');
    Route::post('/kas/kirim', [App\Http\Controllers\Keuangan\KasController::class, 'store']);

    // Route::get('/kelolaan', [App\Http\Controllers\Keuangan\KelolaanController::class, 'index'])->named('kelolaan');
    Route::get('/kelolaan', fn() => view('keuangan.kelolaan'))->named('kelolaan');
    Route::post('/kelolaan/kirim', [App\Http\Controllers\Keuangan\KelolaanController::class, 'store']);

    // Route::get('/penerimaan', [App\Http\Controllers\Keuangan\PenerimaanController::class, 'index'])->named('penerimaan');
    Route::get('/penerimaan', fn() => view('keuangan.penerimaan'))->named('penerimaan');
    Route::post('/penerimaan/kirim', [App\Http\Controllers\Keuangan\PenerimaanController::class, 'store']);

    Route::get('/pengeluaran', [App\Http\Controllers\Keuangan\PengeluaranController::class, 'index'])->named('pengeluaran');
    Route::post('/pengeluaran/kirim', [App\Http\Controllers\Keuangan\PengeluaranController::class, 'store']);
});

Route::middleware(['ceklogin'])->prefix('ikt')->group(function () {

    Route::get('/visite1', [App\Http\Controllers\IKT\Visite1Controller::class, 'index'])->named('visite1');
    Route::post('/visite1/kirim', [App\Http\Controllers\IKT\Visite1Controller::class, 'store']);

    Route::get('/visite2', [App\Http\Controllers\IKT\Visite2Controller::class, 'index'])->named('visite2');
    Route::post('/visite2/kirim', [App\Http\Controllers\IKT\Visite2Controller::class, 'store']);

    Route::get('/visite3', [App\Http\Controllers\IKT\Visite3Controller::class, 'index'])->named('visite3');
    Route::post('/visite3/kirim', [App\Http\Controllers\IKT\Visite3Controller::class, 'store']);

    Route::get('/pobo', [App\Http\Controllers\IKT\POBOController::class, 'index'])->named('pobo');
    Route::post('/pobo/kirim', [App\Http\Controllers\IKT\POBOController::class, 'store']);

    Route::get('/visite_pertama', [App\Http\Controllers\IKT\VisitePertamaController::class, 'index'])->named('visite_pertama');
    Route::post('/visite_pertama/kirim', [App\Http\Controllers\IKT\VisitePertamaController::class, 'store']);

    Route::get('/dpjp_non_visite', [App\Http\Controllers\IKT\DPJPTidakVisiteController::class, 'index'])->named('dpjp_non_visite');
    Route::post('/dpjp_non_visite/kirim', [App\Http\Controllers\IKT\DPJPTidakVisiteController::class, 'store']);

    Route::get('/kepuasan_pasien', [App\Http\Controllers\IKT\KepuasanPasienController::class, 'index'])->named('kepuasan_pasien');
    Route::post('/kepuasan_pasien/kirim', [App\Http\Controllers\IKT\KepuasanPasienController::class, 'store']);

    Route::get('/waktu_tunggu_ralan', [App\Http\Controllers\IKT\WaktuTungguRalanController::class, 'index'])->named('waktu_tunggu_ralan');
    Route::post('/waktu_tunggu_ralan/kirim', [App\Http\Controllers\IKT\WaktuTungguRalanController::class, 'store']);

    Route::get('/penyelenggaraan_erm', [App\Http\Controllers\IKT\PenyelenggaraanERMController::class, 'index'])->named('penyelenggaraan_erm');
    Route::post('/penyelenggaraan_erm/kirim', [App\Http\Controllers\IKT\PenyelenggaraanERMController::class, 'store']);

    Route::get('/kepatuhan_penggunaan_apd', [App\Http\Controllers\IKT\KepatuhanPenggunaanAPDController::class, 'index'])->named('kepatuhan_penggunaan_apd');
    Route::post('/kepatuhan_penggunaan_apd/kirim', [App\Http\Controllers\IKT\KepatuhanPenggunaanAPDController::class, 'store']);

    Route::get('/penundaan_operasi_elektif', [App\Http\Controllers\IKT\PenundaanOperasiElektifController::class, 'index'])->named('penundaan_operasi_elektif');
    Route::post('/penundaan_operasi_elektif/kirim', [App\Http\Controllers\IKT\PenundaanOperasiElektifController::class, 'store']);

    Route::get('/kepatuhan_clinical_pathway', [App\Http\Controllers\IKT\KepatuhanClinicalPathwayController::class, 'index'])->named('kepatuhan_clinical_pathway');
    Route::post('/kepatuhan_clinical_pathway/kirim', [App\Http\Controllers\IKT\KepatuhanClinicalPathwayController::class, 'store']);

    Route::get('/kepatuhan_kebersihan_tangan', [App\Http\Controllers\IKT\KepatuhanKebersihanTanganController::class, 'index'])->named('kepatuhan_kebersihan_tangan');
    Route::post('/kepatuhan_kebersihan_tangan/kirim', [App\Http\Controllers\IKT\KepatuhanKebersihanTanganController::class, 'store']);

    Route::get('/kepatuhan_penggunaan_fornas', [App\Http\Controllers\IKT\KepatuhanPenggunaanFornasController::class, 'index'])->named('kepatuhan_penggunaan_fornas');
    Route::post('/kepatuhan_penggunaan_fornas/kirim', [App\Http\Controllers\IKT\KepatuhanPenggunaanFornasController::class, 'store']);

    Route::get('/kepatuhan_waktu_visite_dpjp', [App\Http\Controllers\IKT\KepatuhanWaktuVisiteDPJPController::class, 'index'])->named('kepatuhan_waktu_visite_dpjp');
    Route::post('/kepatuhan_waktu_visite_dpjp/kirim', [App\Http\Controllers\IKT\KepatuhanWaktuVisiteDPJPController::class, 'store']);

    Route::get('/kepatuhan_pelaksanaan_prokes', [App\Http\Controllers\IKT\KepatuhanPelaksanaanProkesController::class, 'index'])->named('kepatuhan_pelaksanaan_prokes');
    Route::post('/kepatuhan_pelaksanaan_prokes/kirim', [App\Http\Controllers\IKT\KepatuhanPelaksanaanProkesController::class, 'store']);

    Route::get('/pembelian_alkes_dalam_negeri', [App\Http\Controllers\IKT\PembelianAlkesDalamNegeriController::class, 'index'])->named('pembelian_alkes_dalam_negeri');
    Route::post('/pembelian_alkes_dalam_negeri/kirim', [App\Http\Controllers\IKT\PembelianAlkesDalamNegeriController::class, 'store']);

    Route::get('/kepatuhan_identifikasi_pasien', [App\Http\Controllers\IKT\KepatuhanIdentifikasiPasienController::class, 'index'])->named('kepatuhan_identifikasi_pasien');
    Route::post('/kepatuhan_identifikasi_pasien/kirim', [App\Http\Controllers\IKT\KepatuhanIdentifikasiPasienController::class, 'store']);

    Route::get('/kepatuhan_waktu_visite_dokter', [App\Http\Controllers\IKT\KepatuhanWaktuVisiteDokterController::class, 'index'])->named('kepatuhan_waktu_visite_dokter');
    Route::post('/kepatuhan_waktu_visite_dokter/kirim', [App\Http\Controllers\IKT\KepatuhanWaktuVisiteDokterController::class, 'store']);

    Route::get('/kecepatan_waktu_tunggu_komplain', [App\Http\Controllers\IKT\KecepatanWaktuTungguKomplainController::class, 'index'])->named('kecepatan_waktu_tunggu_komplain');
    Route::post('/kecepatan_waktu_tunggu_komplain/kirim', [App\Http\Controllers\IKT\KecepatanWaktuTungguKomplainController::class, 'store']);

    Route::get('/pelaporan_hasil_kritis_laboratorium', [App\Http\Controllers\IKT\PelaporanHasilKritisLaboratoriumController::class, 'index'])->named('pelaporan_hasil_kritis_laboratorium');
    Route::post('/pelaporan_hasil_kritis_laboratorium/kirim', [App\Http\Controllers\IKT\PelaporanHasilKritisLaboratoriumController::class, 'store']);

    Route::get('/waktu_tanggap_operasi_seksio_sesarea', [App\Http\Controllers\IKT\WaktuTanggapOperasiSeksioSesareaController::class, 'index'])->named('waktu_tanggap_operasi_seksio_sesarea');
    Route::post('/waktu_tanggap_operasi_seksio_sesarea/kirim', [App\Http\Controllers\IKT\WaktuTanggapOperasiSeksioSesareaController::class, 'store']);

    Route::get('/kepatuhan_upaya_pencegahan_risiko_pasien_jatuh', [App\Http\Controllers\IKT\KepatuhanUpayaPencegahanResikoPasienJatuhController::class, 'index'])->named('kepatuhan_upaya_pencegahan_risiko_pasien_jatuh');
    Route::post('/kepatuhan_upaya_pencegahan_risiko_pasien_jatuh/kirim', [App\Http\Controllers\IKT\KepatuhanUpayaPencegahanResikoPasienJatuhController::class, 'store']);

    Route::get('/pertumbuhan_realisasi_pendapatan_pengelolaan_aset_blu', [App\Http\Controllers\IKT\PertumbuhanRealisasiPendapatanPengelolaanAsetBLUController::class, 'index'])->named('pertumbuhan_realisasi_pendapatan_pengelolaan_aset_blu');
    Route::post('/pertumbuhan_realisasi_pendapatan_pengelolaan_aset_blu/kirim', [App\Http\Controllers\IKT\PertumbuhanRealisasiPendapatanPengelolaanAsetBLUController::class, 'store']);
});

Route::middleware(['ceklogin'])->prefix('monitoring')->group(function () {
    Route::get('scheduler', fn() => view('monitoring.scheduler'))->named('scheduler');
});

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])->middleware('ceklogin');
Route::match(['get', 'post'], '/botman', [BotManController::class, 'handle']);    
Route::get('/chat',function(){
    return view('telegram');
});

Route::get('/artisan', function(){
    Artisan::call('cron:layanan 2022');
    dd();
});
