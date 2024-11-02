<?php

declare(strict_types=1);

namespace alonetech\simhash\demo;

use alonetech\simhash\comparator\DefaultComparator;
use alonetech\simhash\tokenizer\String64Tokenizer;
use alonetech\simhash\{SimHash, FingerPrint};

error_reporting(E_ALL);

defined('DEBUG') || define('DEBUG', true);

class Demo
{
    const DEMO_CONTENT1 = <<<EOT
SimHash算法是一种高效的文本去重算法，其核心思想是将高维的特征向量转化为一个低维的指纹（fingerprint），通过计算两个指纹的海明距离（Hamming distance）来判断文本的相似度。然而，在SimHash算法的原理和步骤中，并未直接涉及到高斯分布的计算。
高斯分布，也叫正态分布，在机器学习和统计学中具有广泛的应用。它的数学性质十分优秀，概率密度函数具有连续性、可微性和单调性，且具有最大似然估计的性质。这些性质使得高斯分布成为很多机器学习算法和模型的基础。例如，在贝叶斯分类器中，高斯分布可用于估计每个类别的概率分布；在聚类分析中，高斯混合模型可用于描述数据的概率分布，并用于对数据进行聚类。
但SimHash算法本身并不直接依赖于高斯分布的计算。SimHash算法主要依赖于文本的分词、哈希函数的选择、权重的分配、合并和降维等步骤。其中，哈希函数的选择对SimHash算法的效果有重要影响，建议选择具有较高散列性的哈希函数以提高算法的准确性。权重的分配也应根据实际情况进行调整，以更好地反映分词在文本中的重要性。
因此，SimHash算法用到高斯分布的计算这一说法是不准确的。SimHash算法和高斯分布在各自的领域内有着广泛的应用和独特的优势，但二者之间并没有直接的联系。如果在实际应用中需要将SimHash算法与高斯分布相结合，可能是出于特定的应用场景或需求考虑，但这并不是SimHash算法本身的必要步骤或要求。
EOT;

    const DEMO_CONTENT2 = <<<EOT
SimHash算法是一种高效的文本去重算法，其核心思想是将高维的特征向量转化为一个低维的指纹（fingerprint），通过计算两个指纹的海明距离（Hamming distance）来判断文本的相似度。然而，在SimHash算法的原理和步骤中，并未直接涉及到高斯分布的计算。
高斯分布，也叫正态分布，在机器学习和统计学中具有广泛的应用。它的数学性质十分优秀，概率密度函数具有连续性、可微性和单调性，且具有最大似然估计的性质。这些性质使得高斯分布成为很多机器学习算法和模型的基础。例如，在贝叶斯分类器中，高斯分布可用于估计每个类别的概率分布；在聚类分析中，高斯混合模型可用于描述数据的概率分布，并用于对数据进行聚类。
但SimHash算法本身并不是直接依赖于高斯分布的计算。SimHash算法主要依赖于文本的分词、哈希函数的选择、权重的分配、合并和降维等步骤。其中，哈希函数的选择对SimHash算法的效果有重要影响，建议选择具有较高散列性的哈希函数以提高算法的准确性。权重的分配也应根据实际情况进行调整，以更好地反映分词在文本中的重要性。
因此，SimHash算法用到高斯分布的计算这一说法是不准确的。SimHash算法与高斯分布在各自的领域内有着广泛的应用和独特的优势，但二者之间并没有直接的联系。如果在实际应用中需要将SimHash算法与高斯分布相结合，可能是出于特定的应用场景或需求考虑，但这并不是SimHash算法本身的必要步骤或要求。
EOT;
    const DEMO_CONTENT3 = '贾君鹏，你妈妈喊你回家吃饭！';

    const DEMO_CONTENT4 = '贾君鹏，你妈妈叫你回家吃饭！';
    public function run()
    {
        try {
            $simHash = new SimHash();
            $fp1 = $simHash->hash(static::DEMO_CONTENT1);
            $fp2 = $simHash->hash(static::DEMO_CONTENT2);
            var_dump((string)$fp1, (string)$fp2);
            $comparator = new DefaultComparator();
            $similarity = $comparator->compare($fp1, $fp2);
            var_dump($similarity);
            $simHash2 = new SimHash(tokenizer: new String64Tokenizer());
            $fp3 = $simHash2->hash(static::DEMO_CONTENT3);
            $fp4 = $simHash2->hash(static::DEMO_CONTENT4);
            var_dump((string)$fp3, (string)$fp4);
            $similarity = $comparator->compare($fp3, $fp4);
            var_dump($similarity);
            var_dump((string)(new FingerPrint())->load((string)$fp3));
            var_dump((string)(new FingerPrint())->load((string)$fp1));
            var_dump((string)(new FingerPrint())->loadData($fp2->getData()));
        } catch (\Throwable $ex) {
            var_dump($ex);
        }
    }
}

// 命令行入口文件
// 加载基础文件
require __DIR__ . '/../vendor/autoload.php';

// 应用初始化
(new Demo())->run();
