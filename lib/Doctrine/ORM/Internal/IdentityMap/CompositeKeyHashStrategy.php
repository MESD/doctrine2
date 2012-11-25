<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace Doctrine\ORM\Internal\IdentityMap;

use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * The composite key hash strategy works on composite, non-derived keys.
 *
 * Applying this strategy guarantees that the order of the identifiers passed
 * alaways leads to the same hash, independent of the order of the fields in the array.
 *
 * Important: Hashes are seperated by a space, meaning that identifier values
 * that contain spaces themselves may lead to id hash duplicates.
 */
class CompositeKeyHashStrategy implements IdentifierHashStrategy
{
    /**
     * @var \Doctrine\ORM\Mapping\ClassMetadata
     */
    private $class;

    public function __construct(ClassMetadata $class)
    {
        $this->class = $class;
    }

    public function getHash(array $identifier)
    {
        return implode(
            ' ',
            array_map(function ($fieldName) use ($identifier) {
                return $identifier[$fieldName];
            }, $this->class->identifier)
        );
    }
}

