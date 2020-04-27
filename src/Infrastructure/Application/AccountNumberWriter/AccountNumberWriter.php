<?php

declare(strict_types=1);

namespace App\Infrastructure\Application\AccountNumberWriter;

use App\Application\AccountNumberWriter\AccountNumberWriterInterface;
use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final class AccountNumberWriter implements AccountNumberWriterInterface
{
    private const RESULT_PATH = 'data/result.txt';

    /**
     * @var string
     */
    private string $resultPath;

    /**
     * AccountNumberReader constructor.
     *
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->resultPath = sprintf(
            '%s/%s',
            $parameterBag->get('kernel.project_dir'),
            self::RESULT_PATH
        );
    }

    /**
     * @inheritDoc
     */
    public function save(int $status, string $accountNumber): void
    {
        $handle = fopen($this->resultPath, 'a+');
        if ($handle) {
            fwrite(
                $handle,
                sprintf(
                    "%s %s \n",
                    $accountNumber,
                    $this->mapStatus($status)
                )
            );

            fclose($handle);
        } else {
            throw new Exception('File saving failed');
        }
    }

    private function mapStatus(int $status): string
    {
        switch ($status) {
            case 1:
                return '';
            case 2:
                return 'ERR';
            case 3:
                return 'ILL';
            default:
                throw new Exception('Mapping not exist for status.');
        }
    }
}
