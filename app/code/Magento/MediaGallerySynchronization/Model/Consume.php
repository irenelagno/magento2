<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\MediaGallerySynchronization\Model;

use Magento\Framework\Exception\LocalizedException;
use Magento\MediaGallerySynchronizationApi\Api\SynchronizeFilesInterface;
use Magento\MediaGallerySynchronizationApi\Api\SynchronizeInterface;

/**
 * Media gallery image synchronization queue consumer.
 */
class Consume
{
    /**
     * @var SynchronizeInterface
     */
    private $synchronize;

    /**
     * @var SynchronizeFilesInterface
     */
    private $synchronizeFiles;

    /**
     * @param SynchronizeInterface $synchronize
     * @param SynchronizeFilesInterface $synchronizeFiles
     */
    public function __construct(
        SynchronizeInterface $synchronize,
        SynchronizeFilesInterface $synchronizeFiles
    ) {
        $this->synchronize = $synchronize;
        $this->synchronizeFiles = $synchronizeFiles;
    }

    /**
     * Run media files synchronization.
     * @param string[] $message
     * @throws LocalizedException
     */
    public function execute(array $message) : void
    {
        $this->synchronize->execute();

        if (!empty($message)) {
            $this->synchronizeFiles->execute($message);
        }
    }
}
