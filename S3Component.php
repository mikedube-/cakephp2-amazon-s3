<?php
/**
* $Id$
*
* Copyright (c) 2011, Michael Dubé.  All rights reserved.
*
* Redistribution and use in source and binary forms, with or without
* modification, are permitted provided that the following conditions are met:
*
* - Redistributions of source code must retain the above copyright notice,
*   this list of conditions and the following disclaimer.
* - Redistributions in binary form must reproduce the above copyright
*   notice, this list of conditions and the following disclaimer in the
*   documentation and/or other materials provided with the distribution.
*
* THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
* AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
* IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
* ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
* LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
* CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
* SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
* INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
* CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
* ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
* POSSIBILITY OF SUCH DAMAGE.
*
* Amazon S3 is a trademark of Amazon.com, Inc. or its affiliates.
*/

/**
* Amazon S3 Cakephp 2 Component
*
* Based on work of Donovan Schönknecht > http://undesigned.org.za/2007/10/22/amazon-s3-php-class
* 
* @link https://github.com/mikedube-/cakephp2-amazon-s3
* @version 0.1-dev
*/

class S3Component extends Component {
    /**
     * @var object S3 Vendor instance
     */
    private $S3Vendor;
    
    /*
    * =====================
    * Component Overloading
    */

    public function initialize( $controller ) {
        App::import( 'Vendor', 'S3' );

        $this->S3Vendor   =   new S3( EXTERNAL_SERVICE_S3_ACCESS_KEY, EXTERNAL_SERVICE_S3_SECRET_KEY );
    }

    /*
    * =====================
    * Public Methods
    */

    /**
     * PUT an object based on a file system path
     *
     * @param string $path Absolute path of the file to upload
     * @param string $prefix Prefix (should be used to upload in folder, by exemple)
     * @return bool $s3Result Result of the upload
     */
    public function addObjectFromFilePath( $path, $prefix = null ) {
        $s3Result =   $this->S3Vendor->putObject(
            $this->S3Vendor->inputFile(
                $path, false
            ),
            EXTERNAL_SERVICE_S3_BUCKET,
            $prefix . $this->random(),
            S3::ACL_PUBLIC_READ
        );

        return $s3Result;
    }

    /*
    * =====================
    * Private Methods
    */

    private function random( $length = 20 ) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = uniqid( '', true );    
        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[ mt_rand( 0, strlen( $characters -1  ) ) ];
        }
        return $string;
    }

}