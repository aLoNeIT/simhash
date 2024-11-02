<?php

declare(strict_types=1);

namespace alonetech\simhash\tokenizer;

/**
 * 字符串128位令牌处理
 * 
 * @author aLoNe.Adams.K <alone@alonetech.com>
 */
class String64Tokenizer implements TokenizerInterface
{
    /** @inheritDoc */
    public function tokenize(string $word): string
    {
        // 使用md5进行hash计算
        $md5Binary = \md5($word, true);
        $binaryStr = '';
        // 循环处理每一个字节，转换成十六进制字符串
        for ($i = 0; $i < strlen($md5Binary) / 2; $i++) {
            $byte = \ord($md5Binary[$i]);
            $binaryStr .= \str_pad(\decbin($byte), 8, '0', STR_PAD_LEFT);
        }
        return $binaryStr;
    }
    /** @inheritDoc */
    public function supportSize(): int
    {
        return 64;
    }
}
