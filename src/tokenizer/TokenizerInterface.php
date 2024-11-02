<?php

declare(strict_types=1);

namespace alonetech\simhash\tokenizer;

/**
 * 令牌化接口
 * 
 * @author aLoNe.Adams.K <alone@alonetech.com>
 */
interface TokenizerInterface
{
    /**
     * 令牌化单词
     *
     * @param string $word 单词
     * @return string 返回序列化后的字符串
     */
    public function tokenize(string $word): string;
    /**
     * 支持的令牌化长度
     *
     * @return integer
     */
    public function supportSize(): int;
}
