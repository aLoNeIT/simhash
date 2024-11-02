<?php

declare(strict_types=1);

namespace alonetech\simhash\vectorizer;

/**
 * 向量处理
 */
interface VectorizerInterface
{
    /**
     * 权重值
     */
    const WEIGHT_VALUE = 1;
    /**
     * 向量化处理
     *
     * @param array $tokens 待处理的令牌数组
     * @param integer $size 令牌长度
     * @return array 返回向量处理后的数组，大小为令牌长度
     */
    public function vectorize(array $tokens, int $size): array;
}
