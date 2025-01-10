<?php

class Sale {
    public int $sale_id;
    public float $sale_pay;
    public float $sale_change;
    public float $sale_totalPrice;
    public string $sale_status = "";
    public string $sale_date;
    public int $id_user;
    public int $id_member;

    /** @var DetailSale[] */
    public array $detailSale = []; // Menggunakan array untuk menyimpan daftar DetailSale

    public function __construct(
        int $sale_id,
        float $sale_pay,
        float $sale_change,
        float $sale_totalPrice,
        string $sale_status,
        string $sale_date,
        int $id_user,
        int $id_member,
        /** @var DetailSale[] */
        array $detailSale = [] // Menempatkan $detailSale sebagai parameter opsional terakhir
    ) {
        $this->sale_id = $sale_id;
        $this->sale_pay = $sale_pay;
        $this->sale_change = $sale_change;
        $this->sale_totalPrice = $sale_totalPrice;
        $this->sale_status = $sale_status;
        $this->sale_date = $sale_date;
        $this->id_user = $id_user;
        $this->id_member = $id_member;
        $this->detailSale = $detailSale;
    }
}