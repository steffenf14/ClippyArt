<?php
declare(strict_types=1);

namespace CakeMasterOfPie\OldSchool;

/**
 *       __________________________________________________________
 *      /                                                          \
 *     (  It looks like you were trying to have an awesome message  )
 *      \_  _______________________________________________________/
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
 *
 * Class ClippyArt
 * @package CakeMasterOfPie\OldSchool
 */
class ClippyArt
{
    /**
     *
     */
    private const MIN_TEXT_LENGTH = 3;
    /**
     *
     */
    private const MAX_TEXT_LENGTH = 150;
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
     */
    public function setMaxTextLength(int $maxTextLength): void
    {
        if ($maxTextLength < self::MIN_TEXT_LENGTH) {
            $this->maxTextLength = self::MIN_TEXT_LENGTH;
        } else {
            if ($maxTextLength > self::MAX_TEXT_LENGTH) {
                $this->maxTextLength = self::MAX_TEXT_LENGTH;
            }
        }
        $this->maxTextLength = $maxTextLength;
    }

    /**
     * @param string $text
     *
     * @return string
     */
    public function getClippyArt(string $text): string
    {
        return $this->getBubble($text) . "\n" . $this->elementParts['clippy'];
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

        return $bubbleLine . "\n";
    }

    /**
     * @param string $text
     *
     * @return string
     */
    private function getBubble(string $text): string
    {
        $blubble = "\n";
        $length = $this->maxTextLength;
        $linesOfText = $this->splitTextRespectingWords($text);

        if (count($linesOfText) <= 1) {
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
        for ($i = 1; $i <= $length - 3; $i++) {
            $topLine .= '_';
        }
        $topLine .= $this->elementParts['bubble']['top']['right']['top'] . "\n";
        $topLine .= $this->elementParts['bubble']['top']['left']['lower'];
        for ($i = 1; $i <= $length - 3; $i++) {
            $topLine .= ' ';
        }
        $topLine .= $this->elementParts['bubble']['top']['right']['lower'];

        return $topLine . "\n";
    }

    /**
     * @param int $length
     *
     * @return string
     */
    private function getLowerBubbleLine(int $length): string
    {
        $lowerLine = $this->elementParts['bubble']['lower']['left'];

        for ($i = 1; $i <= $length - 3; $i++) {
            $lowerLine .= '_';
        }
        $lowerLine .= $this->elementParts['bubble']['lower']['right'];

        $lowerLine .= "\n" . $this->elementParts['bubble']['lower']['start'];

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

        $linesOfText = array_map(function ($line) {
            return trim($line);
        }, $linesOfText);

        return $linesOfText;
    }
}
