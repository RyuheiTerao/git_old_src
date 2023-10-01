<?php

namespace Black_Jack;

interface PlayerInterface
{
    public function drawCards(Deck $deck, int $drawNum): array;
    public function addCard(Deck $deck): array;
    public function getHands(): array;
    public function getPoint():int;

    public function getPlayerInformation();
    public function answerAddCard():string;
}
