<?php
namespace Snippet\Security;

/**
 * Interface for csrf token generator
 * @author Zamrony P. Juhara
 */
interface CsrfTokenGeneratorInterface
{
    /**
     * Create new object with field name `name` and `token` which
     * contains token name and token value
     * @return \StdClass
     */
    public function generateCsrfToken();
}
