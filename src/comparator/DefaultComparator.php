<?php

declare(strict_types=1);

namespace alonetech\simhash\comparator;

use alonetech\simhash\FingerPrint;

/**
 * 高斯对比器
 * 
 * @author aLoNe.Adams.K <alone@alonetech.com>
 */
class DefaultComparator implements ComparatorInterface
{
    /**
     * 偏差值
     *
     * @var integer
     */
    protected int $deviation = 3;
    /**
     * 构造函数
     *
     * @param integer $deviation 偏差值
     */
    public function __construct($deviation = 3)
    {
        $this->deviation = $deviation;
    }
    /** @inheritDoc */
    public function compare(FingerPrint $fp1, FingerPrint $fp2): float
    {
        // 判断长度是否一样
        if ($fp1->getDataSize() !== $fp2->getDataSize()) {
            throw new \LogicException(sprintf(
                '高斯对比器不支持两个长度不一致的指纹 （%s 位和%s 位）',
                $fp1->getDataSize(),
                $fp2->getDataSize()
            ));
        }
        // 依次对两个指纹的每个原始数据进行比较，异或运算，异或相同位置不一样则为1
        $count = $fp1->getDataCount();
        $size = $fp1->getDataSize();
        $data1 = $fp1->getData();
        $data2 = $fp2->getData();
        $diffNum = 0;
        for ($i = 0; $i < $count; $i++) {
            $diff = $data1[$i] ^ $data2[$i];
            $diffNum += \substr_count(\decbin($diff), '1');
        }
        var_dump($diffNum);
        return $this->computeSimilarity($diffNum, $size);
    }

    /**
     * 相似度计算
     *
     * @param int $diffCount 偏差值
     * @return float 返回相似度
     */
    protected function computeSimilarity(int $diffCount, int $size): float
    {
        // 基于八成相似公式，计算相似度
        // 先计算在指定指纹长度下，相似度系数比例
        $overCoefficient = 1 / ($size - $this->deviation) * 0.8;
        $standardCoefficient = 1 / $this->deviation * 0.2;
        $offset = $diffCount - $this->deviation;
        if ($offset > 0) {
            // 偏差大于0，则根据系数计算实际比例
            $ratio = $offset * $overCoefficient + 0.2;
        } else if (0 == $offset) {
            $ratio = 0.2;
        } else {
            // 小于0，则计算相似度
            $offset = $this->deviation - \abs($offset);
            $ratio = $offset * $standardCoefficient;
        }
        return (float)bcsub('1', (string)$ratio, 4);
    }
}
