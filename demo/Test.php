<?php

// 假设的汉明距离值
$hammingDistance = 5;

// 高斯分布的均值（可根据实际情况调整）
$mean = 0;
// 高斯分布的标准差（可根据实际情况调整）
$stdDeviation = 2;

// 计算基于高斯分布的相似度值并进行归一化处理
function gaussianSimilarityWithNormalization($hammingDistance, $mean, $stdDeviation)
{
    // 计算高斯分布的概率密度函数值
    $exponent = - ((($hammingDistance - $mean) ** 2) / (2 * ($stdDeviation ** 2)));
    $similarity = (1 / ($stdDeviation * sqrt(2 * M_PI))) * exp($exponent);

    // 归一化处理，确保相似度值在0到1之间
    $normalizedSimilarity = max(0, min(1, $similarity));

    return $normalizedSimilarity;
}

// 调用函数计算相似度值并进行归一化处理
$similarityValue = gaussianSimilarityWithNormalization($hammingDistance, $mean, $stdDeviation);

echo "基于高斯分布且归一化后的相似度值为: " . $similarityValue;
