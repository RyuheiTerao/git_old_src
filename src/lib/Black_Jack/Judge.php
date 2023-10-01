<?php

namespace Black_Jack;

require_once('PlayerInterface.php');

class Judge
{
    private array $playerInfo = [
        'User' => 0,
        'Dealer' => 0,
        'CPU1' => 0,
        'CPU2' => 0,
    ];

    public function __construct(array $playerInfo)
    {
        foreach ($playerInfo as $player) {

            $this->playerInfo[$player->getPlayerInformation()] = $player->getPoint();
        }
    }

    public function judgeWinner(): array
    {
        $winner = 'Dealer';
        $winnerPoint = 0;
        foreach ($this->playerInfo as $player => $point) {
            if($point <= 21){
                if($winnerPoint < $point){
                    $winnerPoint = $point;
                    $winner = $player;
                }
            }
        }
        return [$winner, $this->playerInfo];
    }

}

class JudgeSprit
{
    private array $playerInfo = [];

    public function __construct(array $playerInfo)
    {
        foreach ($playerInfo as $player) {

            $this->playerInfo[] = [$player->getPlayerInformation(),$player->getPoint()];
        }
    }

    public function judgeWinner(): array
    {
        $winner = 'Dealer';
        $spritWinFlag = False;
        $result = [];
        $allPlayers =[];
        foreach ($this->playerInfo as $player) {
            if(array_key_exists($player[0],$allPlayers)){
                $allPlayers['User2'] = $player[1];
            }else{
                $allPlayers[$player[0]] = $player[1];
            }
            if($player[1] <= 21){
                $result[$player[0]] = $player[1];
            }
        }
        arsort($allPlayers);
        arsort($result);
        $searchSpritResult = array_keys($result);
        $winner = $searchSpritResult[0];
        if($searchSpritResult[0] === $searchSpritResult[1]){
            $spritWinFlag = True;
        }
        return [$allPlayers,$winner,$spritWinFlag];
    }

}
