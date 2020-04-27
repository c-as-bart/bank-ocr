<?php

declare(strict_types=1);

namespace App\Infrastructure\Application\AccountNumberReader;

use App\Application\AccountNumberReader\AccountNumberReaderInterface;
use App\Application\AccountNumberReader\Dto\AccountNumberReaderDto;
use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final class AccountNumberReader implements AccountNumberReaderInterface
{
    private const ACCOUNT_NUMBERS_PATH = 'data/account_numbers.txt';

    /**
     * @var string
     */
    private string $dataPath;

    /**
     * AccountNumberReader constructor.
     *
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->dataPath = sprintf(
            '%s/%s',
            $parameterBag->get('kernel.project_dir'),
            self::ACCOUNT_NUMBERS_PATH
        );
    }

    /**
     * @inheritDoc
     */
    public function read(): array
    {
        $result = [];
        $rawDigitsTemplate = ['', '', '', '', '', '', '', '', ''];
        $handle = fopen($this->dataPath, 'r');
        if ($handle) {
            $rawDigits = $rawDigitsTemplate;
            $rows = [];
            $rowCounter = 0;

            while (!feof($handle)) {
                $line = '<pre>' . fgets($handle) . '</pre>';
                $line = ltrim($line, "<pre>");
                $line = rtrim($line, "</pre>");
                $line = rtrim($line, "\n");
                $rows[] = str_split($line, 3);
                $rowCounter++;

                if ($rowCounter === 3) {
                    $columnCounter = 0;

                    foreach ($rows as $row) {
                        foreach ($row as $column) {
                            $rawDigits[$columnCounter] .= $column;
                            $columnCounter++;
                        }

                        $columnCounter = 0;
                    }

                    $digits = [];
                    foreach ($rawDigits as $rawDigit) {
                        $digits[] = $this->getDigit($rawDigit);
                    }

                    $result[] = new AccountNumberReaderDto($digits);
                    $rowCounter = 0;
                    $rows = [];
                    $rawDigits = $rawDigitsTemplate;
                }
            }

            fclose($handle);
        } else {
            throw new Exception('File opening failed');
        }

        return $result;
    }

    private function getDigit(string $rawDigit): ?int
    {
        switch ($rawDigit) {
            case ' _ | ||_|':
                $digit = 0;
                break;
            case '     |  |':
                $digit = 1;
                break;
            case ' _  _||_ ':
                $digit = 2;
                break;
            case ' _  _| _|':
                $digit = 3;
                break;
            case '   |_|  |':
                $digit = 4;
                break;
            case ' _ |_  _|':
                $digit = 5;
                break;
            case ' _ |_ |_|':
                $digit = 6;
                break;
            case ' _   |  |':
                $digit = 7;
                break;
            case ' _ |_||_|':
                $digit = 8;
                break;
            case ' _ |_| _|':
                $digit = 9;
                break;
            default:
                $digit = null;
        }

        return $digit;
    }
}
