<?php
declare(strict_types=1);

namespace Steffenf14\Art;

/**
 *       ___________________________________________________________
 *      /                                                           \
 *     (  It looks like you were trying to have an awesome message.  )
 *     (  btw. i do not handle line breaks.                          )
 *      \_  ________________________________________________________/
 *        )/
 *   ___
 *  /   \
 *  |   |
 *  (o) (o)
 *  |   |/
 *  ||  ||
 *  ||  ||
 *  |\__/|
 *  \____/
 *
 * Class Clippy
 * @package Steffenf14\Art
 */
class Clippy
{
    /**
     *
     */
    private const MIN_TEXT_LENGTH = 3;
    /**
     * @var int
     */
    private $maxTextLength = 60;
    /**
     * @var array
     */
    private $elementParts = [
        'clippy' => '  ___
 /   \
 |   |
 (o) (o)
 |   |/
 ||  ||
 ||  ||
 |\__/|
 \____/',
        'bubble' => [
            'top'   => [
                'left'  => [
                    'top'   => '      ____',
                    'lower' => '     /    '
                ],
                'right' => [
                    'top'   => '_',
                    'lower' => ' \\'
                ]
            ],
            'lower' => [
                'right' => '_/',
                'left'  => '     \_  _',
                'start' => '       )/'
            ],
            'line'  => [
                'start' => '    (  ',
                'end'   => '  )'
            ]

        ]
    ];

    /**
     * @param int $maxTextLength
     *
     * @return void
     */
    public function setMaxTextLength(int $maxTextLength): void
    {
        if ($maxTextLength < self::MIN_TEXT_LENGTH) {
            $maxTextLength = self::MIN_TEXT_LENGTH;
        }
        $this->maxTextLength = $maxTextLength;
    }

    /**
     * @param string $text
     *
     * @return string
     */
    public function getArt(string $text): string
    {
        return $this->getBubble($text) . PHP_EOL . $this->elementParts['clippy'];
    }

    /**
     * @param array $linesOfText
     * @param int   $length
     *
     * @return string
     */
    private function getBubbleLines(array $linesOfText, int $length): string
    {
        $lines = '';
        foreach ($linesOfText as $line) {
            $lines .= $this->getBubbleLine($line, $length);
        }

        return $lines;
    }

    /**
     * @param string $text
     * @param int    $length
     *
     * @return string
     */
    private function getBubbleLine(string $text, int $length): string
    {
        $bubbleLine = $this->elementParts['bubble']['line']['start'];

        if (\strlen($text) < $length) {
            $text = str_pad($text, $length, ' ');
        }

        $bubbleLine .= $text;

        $bubbleLine .= $this->elementParts['bubble']['line']['end'];

        return $bubbleLine . PHP_EOL;
    }

    /**
     * @param string $text
     *
     * @return string
     */
    private function getBubble(string $text): string
    {
        $blubble = PHP_EOL;
        $length = $this->maxTextLength;
        $linesOfText = $this->splitTextRespectingWords($text);

        if (\count($linesOfText) <= 1) {
            $length = \strlen(reset($linesOfText));
            if ($length < self::MIN_TEXT_LENGTH) {
                $length = self::MIN_TEXT_LENGTH;
            }
        }

        $blubble .= $this->getTopBubbleLine($length);
        $blubble .= $this->getBubbleLines($linesOfText, $length);
        $blubble .= $this->getLowerBubbleLine($length);

        return $blubble;
    }

    /**
     * @param int $length
     *
     * @return string
     */
    private function getTopBubbleLine(int $length): string
    {
        $topLine = $this->elementParts['bubble']['top']['left']['top'];
        $topLine .= str_pad('', $length - 3, '_');
        $topLine .= $this->elementParts['bubble']['top']['right']['top'] . PHP_EOL;
        $topLine .= $this->elementParts['bubble']['top']['left']['lower'];
        $topLine .= str_pad('', $length - 3, ' ');
        $topLine .= $this->elementParts['bubble']['top']['right']['lower'];

        return $topLine . PHP_EOL;
    }

    /**
     * @param int $length
     *
     * @return string
     */
    private function getLowerBubbleLine(int $length): string
    {
        $lowerLine = $this->elementParts['bubble']['lower']['left'];

        $lowerLine .= str_pad('', $length - 3, '_');
        $lowerLine .= $this->elementParts['bubble']['lower']['right'];
        $lowerLine .= PHP_EOL . $this->elementParts['bubble']['lower']['start'];
        return $lowerLine;
    }

    /**
     * @param string $text
     *
     * @return array
     */
    private function splitTextRespectingWords(string $text): array
    {
        $arrayWords = explode(' ', $text);
        $currentLength = 0;
        $index = 0;
        $linesOfText = [];
        foreach ($arrayWords as $word) {
            $wordLength = \strlen($word) + 1;
            if (($currentLength + $wordLength) <= $this->maxTextLength) {
                if (!isset($linesOfText[$index])) {
                    $linesOfText[$index] = '';
                }
                $linesOfText[$index] .= $word . ' ';
                $currentLength += $wordLength;
            } else {
                $index++;
                $currentLength = $wordLength;
                $linesOfText[$index] = $word . ' ';
            }
        }
        $linesOfText = array_map('trim', $linesOfText);
        return $linesOfText;
    }
}
