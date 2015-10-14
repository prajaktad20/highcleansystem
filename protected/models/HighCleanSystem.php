<?php

/*
 * Model representing a test bucket in s3
 */
class HighCleanSystem extends S3 {
    
    /**
     * Return the name of this model's bucket.
     */
    public function bucketName() {
        return "highcleansystem";
    }

}
