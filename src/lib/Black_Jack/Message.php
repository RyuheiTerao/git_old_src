<?php

namespace Black_Jack;

require_once('PlayerInterface.php');

class Message
{
    private const POINT_TO_CARD = [
        '1' => 'A',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '6' => '6',
        '7' => '7',
        '8' => '8',
        '9' => '9',
        '10' => '10',
        '11' => 'J',
        '12' => 'Q',
        '13' => 'K',
    ];

    private const MARK_CHANGE_JAPANESE = [
        'C' => 'クラブ',
        'H' => 'ハート',
        'S' => 'スペード',
        'D' => 'ダイヤ',
    ];

    private const PLAYER_CHANGE_JAPANESE = [
        'User' => 'あなた',
        'User2' => 'スプリットしたあなた',
        'Dealer' => 'ディーラー',
        'CPU1' => 'CPU1',
        'CPU2' => 'CPU2',
    ];

    private const WINNER = 0;
    private const PLAYER_INFO = 1;

    public function showStartMessage(): void
    {
        echo 'ブラックジャックを開始します' . PHP_EOL;
    }

    public function showStartHandMessage(PlayerInterface $player): void
    {
        $startHands = $player->getHands();
        if ($player->getPlayerInformation() === 'User') {
            echo 'あなたの引いたカードは' . self::MARK_CHANGE_JAPANESE[$startHands[0]->getSuit()] . 'の' . self::POINT_TO_CARD[$startHands[0]->getNumber()] . 'です。' . PHP_EOL;
            echo 'あなたの引いたカードは' . self::MARK_CHANGE_JAPANESE[$startHands[1]->getSuit()] . 'の' . self::POINT_TO_CARD[$startHands[1]->getNumber()] . 'です。' . PHP_EOL;
        } elseif ($player->getPlayerInformation() === 'Dealer' || $player->getPlayerInformation() === 'CPU1' || $player->getPlayerInformation() === 'CPU2') {
            echo self::PLAYER_CHANGE_JAPANESE[$player->getPlayerInformation()] . 'の引いたカードは' . self::MARK_CHANGE_JAPANESE[$startHands[0]->getSuit()] . 'の' . self::POINT_TO_CARD[$startHands[0]->getNumber()] . 'です。' . PHP_EOL;
            echo self::PLAYER_CHANGE_JAPANESE[$player->getPlayerInformation()] . 'の引いた2枚目のカードはわかりません。' . PHP_EOL;
        } else {
            echo 'エラー' . PHP_EOL;
        }
    }

    public function showPoint(PlayerInterface $player): void
    {
        echo self::PLAYER_CHANGE_JAPANESE[$player->getPlayerInformation()] . 'の現在の得点は' . (string)$player->getPoint() . 'です。';
    }

    public function questionAddCard(PlayerInterface $player): void
    {
        if ($player->getPlayerInformation() === 'User') {
            echo 'カードを引きますか? (Y/N)' . PHP_EOL;
        } else {
            echo 'エラー' . PHP_EOL;
        }
    }

    public function showAddCard(PlayerInterface $player, array $card): void
    {
        echo self::PLAYER_CHANGE_JAPANESE[$player->getPlayerInformation()] . 'の引いたカードは' . self::MARK_CHANGE_JAPANESE[$card[0]->getSuit()] . 'の' . self::POINT_TO_CARD[$card[0]->getNumber()] . 'でした。' . PHP_EOL;
    }

    public function showCPUCard(PlayerInterface $cpu)
    {
        $startHands = $cpu->getHands();
        echo self::PLAYER_CHANGE_JAPANESE[$cpu->getPlayerInformation()] . 'の引いた2枚目のカードは' . self::MARK_CHANGE_JAPANESE[$startHands[1]->getSuit()] . 'の' . self::POINT_TO_CARD[$startHands[1]->getNumber()] . 'でした。' . PHP_EOL;
    }

    public function showWinner(array $judgeWinner)
    {
        foreach ($judgeWinner[self::PLAYER_INFO] as $player => $point) {
            if ($point === 0) {
                break;
            }
            echo self::PLAYER_CHANGE_JAPANESE[$player] . 'の得点は' . $point . 'です。' . PHP_EOL;
        }
        echo self::PLAYER_CHANGE_JAPANESE[$judgeWinner[self::WINNER]] . 'の勝ちです!' . PHP_EOL;
    }

    public function showEndMessage(): void
    {
        echo 'ブラックジャックを終了します' . PHP_EOL;
    }

    public function questionUserAction(User $user): void
    {
        echo '次の行動を選択してください。(整数で入力)' . PHP_EOL;
        echo '1.カードを引く' . PHP_EOL;
        echo '2.スタンド' . PHP_EOL;
        echo '3.サレンダー' . PHP_EOL;
        if ($user->checkDollar()) {
            echo '4.ダブルダウン' . PHP_EOL;
        }
        if ($this->checkSprit($user->getHands()) && $user->checkDollar() && !($user->getSpritFlag())) {
            echo '5.スプリット' . PHP_EOL;
        }
    }

    private function checkSprit(array $hands): bool
    {
        $result = False;
        if(count($hands) === 2){
            if (($hands[0]->getNumber() === $hands[1]->getNumber())) {
                $result = True;
            }
        }


        return $result;
    }

    public function showMoney(User $user): void
    {
        echo 'あなたの所持金は' . $user->getDollar() . 'です。' . PHP_EOL;
        echo '掛け金を入力してください。' . PHP_EOL;
    }

    public function showActionFaultReason(): void
    {
        echo '所持金が足りません' . PHP_EOL;
    }

    public function showBetAnswer(bool $result, int $bet): void
    {
        if ($result) {
            echo '掛け金は' . $bet . 'で設定されました。' . PHP_EOL;
        } else {
            echo '所持金が不足しています' . PHP_EOL;
        }
    }

    public function showResult(string $winner, User $user):void
    {
        if($winner === 'User'){
            echo 'あなたは勝ちました' . PHP_EOL;
            echo '所持金が' . $user->getDollar() . 'になりました。' . PHP_EOL;
        }else{
            echo 'あなたは負けました' . PHP_EOL;
            echo '所持金が' . $user->getDollar() . 'になりました。' . PHP_EOL;
        }
    }

    public function showSpritWinner(array $judgeWinner)
    {
        foreach ($judgeWinner[0] as $player => $point) {
            echo self::PLAYER_CHANGE_JAPANESE[$player] . 'の得点は' . $point . 'です。' . PHP_EOL;
        }
        echo self::PLAYER_CHANGE_JAPANESE[$judgeWinner[1]] . 'の勝ちです!' . PHP_EOL;
    }

}
