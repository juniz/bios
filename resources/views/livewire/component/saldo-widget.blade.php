<div class="row">
    <div class="col-12 col-sm-12 col-md-4">
        <div class="info-box">
        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-money-bill"></i></span>
            <div wire:init='readyLoadOperasional' class="info-box-content">
                <span class="info-box-text">Operasional</span>
                <span class="info-box-number">
                    @money($operasional)
                </span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-12 col-md-4">
        <div class="info-box">
        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-coins"></i></span>
            <div wire:init='readyLoadKelolaan' class="info-box-content">
                <span class="info-box-text">Dana Kelolaan</span>
                <span class="info-box-number">
                    @money($kelolaan)
                </span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-12 col-md-4">
        <div class="info-box">
        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-briefcase"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Pengelolaan Kas</span>
                <span class="info-box-number">
                    @money($kas)
                </span>
            </div>
        </div>
    </div>
</div>
