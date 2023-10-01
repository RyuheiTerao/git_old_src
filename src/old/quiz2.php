<?php




//　販売個数　の最大　最少を　求める　(同率はすべて出す)　


// 取得したデータを　商品番号　=>　販売個数　に変換
function getInputs(): array
{
    $inputs = array_slice($_SERVER['argv'], 1);
    return array_chunk($inputs, 2);
}

//　売り上げの合計を求める　(税率は10%) 税率は　bcmul($a,TAX);　で計算する
function getSumPrice(array $inputs, int $sumPrice): int
{
    foreach ($inputs as $input) {
        $sumPrice += BREAD_PRICES[(int)$input[BREAD_NUMBER]] * (int)$input[BREAD_BUY_QUANTITY];
    }
    return $sumPrice * (100 + TAX) /100;
}

function viewsMaxMinMerchandiseNumber(array $inputs): void
{
    $BuyBreadMax = 0;
    $BuyBreadMin = 9999;

    foreach ($inputs as $input) {
        if($BuyBreadMax < (int)$input[BREAD_BUY_QUANTITY]){
            $BuyBreadMax = (int)$input[BREAD_BUY_QUANTITY];
        }
        if($BuyBreadMin > (int)$input[BREAD_BUY_QUANTITY]){
            $BuyBreadMin = (int)$input[BREAD_BUY_QUANTITY];
        }
    }

    $BuyBreadMaxNumber = [];
    $BuyBreadMinNumber = [];
    foreach ($inputs as $input) {
        if((int)$input[BREAD_BUY_QUANTITY] === $BuyBreadMax){
            $BuyBreadMaxNumber[] = (int)$input[BREAD_NUMBER];
        }
        if((int)$input[BREAD_BUY_QUANTITY] === $BuyBreadMin){
            $BuyBreadMinNumber[] = (int)$input[BREAD_NUMBER];
        }
    }


    echo '販売個数最大：';
    foreach ($BuyBreadMaxNumber as $num) {
        echo $num . ' ';
    }
    echo PHP_EOL;

    echo '販売個数最少：';
    foreach ($BuyBreadMinNumber as $num) {
        echo $num . ' ';
    }
    echo PHP_EOL;
}


//　商品番号　に対する　値段のまとめた配列を作成　しておく
const BREAD_PRICES = [
    1 => 100,
    2 => 120,
    3 => 150,
    4 => 250,
    5 => 80,
    6 => 120,
    7 => 100,
    8 => 180,
    9 => 50,
    10 => 300,
];


const TAX = 10;
const BREAD_NUMBER = 0;
const BREAD_BUY_QUANTITY = 1;


$sumPrice = 0;


$inputs = getInputs();

$sumPrice = getSumPrice($inputs, $sumPrice);
echo '売り上げの合計：' . $sumPrice . PHP_EOL;
viewsMaxMinMerchandiseNumber($inputs);
