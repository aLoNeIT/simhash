<?php

declare(strict_types=1);

namespace alonetech\simhash\comparator;

use alonetech\simhash\FingerPrint;

/**
 * 指纹比对器
 * 
 * @author aLoNe.Adams.K <alone@alonetech.com>
 */
interface ComparatorInterface
{
    /**
     * 对比给定的两个指纹，返回相似度
     *
     * @param FingerPrint $fp1 指纹1
     * @param FingerPrint $fp2 指纹2
     * @return float 返回相似度
     */
    public function compare(FingerPrint $fp1, FingerPrint $fp2): float;
}
