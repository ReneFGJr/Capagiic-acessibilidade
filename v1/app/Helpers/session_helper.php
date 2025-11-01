<?php

if (!function_exists('getAnonymousSessionId')) {
    function getAnonymousSessionId()
    {
        $session = session();

        // Se ainda não tiver um ID, cria um único e salva na sessão
        if (!$session->has('anon_id')) {
            // Gera um identificador aleatório e único
            $anonId = bin2hex(random_bytes(16)); // 32 caracteres únicos
            $session->set('anon_id', $anonId);
        }

        return $session->get('anon_id');
    }
}
