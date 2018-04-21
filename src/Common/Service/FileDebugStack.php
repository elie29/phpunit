<?php
namespace Common\Service;

use Doctrine\DBAL\Logging\DebugStack;

class FileDebugStack extends DebugStack
{
    const LEN = 120;

    public function flush()
    {
        $filename = BE_PATH . '/cache/queries.log';
        $data = $this->getQueries();
        file_put_contents($filename, $data, FILE_APPEND | LOCK_EX);
    }

    private function getQueries(): string
    {
        $res = str_repeat('-', self::LEN) . PHP_EOL;
        foreach ($this->queries as $item) {
            $res .= $item['executionMS'] . 'ms - ' . $item['sql'];
            $res .= $this->implode($item['params']);
        }

        return $res . str_repeat('-', self::LEN) . PHP_EOL;
    }

    private function implode($params): string
    {
        if ($params) {
            return ' - ' . implode(', ', $params) . PHP_EOL;
        }
        return PHP_EOL;
    }
}

