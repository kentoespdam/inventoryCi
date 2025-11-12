const DateHelper = {
    getBulan: bln => {
        const arrBulan = [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember",
        ]

        return arrBulan[bln]
    },
    getHari: hr => {
        const arrHari = [
            "Minggu",
            "Senin",
            "Selasa",
            "Rabu",
            "Kamis",
            "Jumat",
            "Sabtu",
        ]

        return arrHari[hr]
    },
    generateTanggal: tgl => {
        let nTgl = new Date(tgl)
        let tanggal = nTgl.getDate();
        let hari = dateHelper.getHari(nTgl.getDay())
        let bulan = dateHelper.getBulan(nTgl.getMonth())
        let tahun = nTgl.getFullYear()

        return `${hari}, ${tanggal} ${bulan} ${tahun}`
    },
    generateFullTanggal: tgl => {
        let nTgl = new Date(tgl)
        let tanggal = nTgl.getDate();
        let hari = dateHelper.getHari(nTgl.getDay())
        let bulan = dateHelper.getBulan(nTgl.getMonth())
        let tahun = nTgl.getFullYear()
        let jam = nTgl.toLocaleTimeString()

        return `${hari}, ${tanggal} ${bulan} ${tahun} ${jam}`
    },
    generateYmd: (tgl = null) => {
        let nTgl = (tgl) ? new Date(tgl) : new Date()
        let tanggal = nTgl.getDate();
        if (tanggal < 10) tanggal = `0${tanggal}`
        let bulan = nTgl.getMonth() + 1;
        if (bulan < 10) bulan = `0${bulan}`
        let tahun = nTgl.getFullYear();

        return `${tahun}-${bulan}-${tanggal}`
    },
    src_umur: (tgl) => {
        //cari umur
        const today = new Date();
        const lahir = new Date(tgl)
        //1tahun dalam ms
        const oneth = 365.25 * 24 * 60 * 60 * 1000;
        //1bulan dalam ms
        const onebl = 30.43 * 24 * 60 * 60 * 1000;
        //1hari dalam ms
        const onehr = 24 * 60 * 60 * 1000;
        //umur dalam ms
        let selisih = today - lahir;
        //Umur Tahun
        let umurTh = Math.floor(selisih / oneth);
        let umutThInms = umurTh * oneth;
        //Umur Bulan dalam Ms
        let selisihBulan = selisih - umutThInms;
        //Umur Bulan
        let umurBl = Math.floor(selisihBulan / onebl);
        let umurBlInms = umurBl * onebl;
        //Umur Hari dalam ms
        let selisihHr = selisihBulan - umurBlInms;
        //Umur Hari
        let umurHr = Math.floor(selisihHr / onehr);
        $('#umurthn').val(umurTh);
        $('#umurbln').val(umurBl);
        $('#umurhr').val(umurHr);
    },
    umurTh: (tgl) => {
        const today = new Date();
        const lahir = new Date(tgl)
        //1tahun dalam ms
        const oneth = 365.25 * 24 * 60 * 60 * 1000;
        let selisih = today - lahir;
        return Math.floor(selisih / oneth)
    }
}

export { DateHelper }