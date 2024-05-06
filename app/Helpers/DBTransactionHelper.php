<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Throwable;

class DBTransactionHelper
{

    public static function transaction(callable $function, callable $rollback, bool $useIsolation = false): mixed
    {
        return self::enabledTransaction($function, $rollback, $useIsolation);
    }

    private static function enabledTransaction(
        callable $function,
        callable $rollback,
        bool     $useIsolation = false
    ): mixed
    {
        if ($useIsolation) {
            $pdo = DB::connection()->getPdo();
            $pdo->exec('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');
        }

        DB::beginTransaction();
        try {
            $result = $function();
            DB::commit();
            return $result;
        } catch (Throwable $exception) {
            DB::rollBack();
            return $rollback($exception);
        }
    }
}