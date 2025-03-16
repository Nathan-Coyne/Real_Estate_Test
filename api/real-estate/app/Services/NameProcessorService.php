<?php

namespace App\Services;

class NameProcessorService
{
    public static function slitString(string $string): array
    {
        return explode(' ', $string);
    }

    public static function hasTwoNames(array $string): bool
    {
        return count($string) === 2;
    }

    public static function hasPartner(string $string): bool
    {
        return preg_match('/\s*(and|&)\s*/', $string) === 1;
    }

    public static function isInitial(string $string): bool
    {
        return strlen($string) < 3;
    }

    public static function formatEstateAgent(string $string): array
    {
        $formattedEstateAgent = [
            'title' => null,
            'first_name' => null,
            'last_name' => null,
            'initial' => null,
        ];

        $data = self::slitString($string);

        if (count($data) === 1) {
            $formattedEstateAgent['title'] = $data[0];
            return $formattedEstateAgent;
        }

        if (count($data) === 2) {
            $formattedEstateAgent['title'] = $data[0];
            $formattedEstateAgent['last_name'] = $data[1];
            return $formattedEstateAgent;
        }

        $formattedEstateAgent['title'] = $data[0];
        $formattedEstateAgent['last_name'] = $data[2];

        if (self::isInitial($data[1])) {
            $formattedEstateAgent['initial'] = $data[1];
        } else {
            $formattedEstateAgent['first_name'] = $data[1];
        }


        return $formattedEstateAgent;
    }

    public static function splitPartnerAgents(string $estateAgent): ?array
    {
        if (!self::hasPartner($estateAgent)) {
            return null;
        }

        return preg_split('/\s*(and|&)\s*/', $estateAgent);
    }

    public static function completeDataFromPartnerAgent(array $estateAgent): array
    {
        $agents = [];
        foreach ($estateAgent as $agent) {
            $agents[] = self::formatEstateAgent($agent);
        }
        $agents[0] = self::overridePartnerLastName($agents[0], $agents[1]);
        $agents[1] = self::overridePartnerLastName($agents[1], $agents[0]);
        return $agents;
    }

    public static function overridePartnerLastName(array $primaryAgents, array $fallbackAgents): array
    {
        if ($primaryAgents['last_name'] === null && $fallbackAgents['last_name'] !== null) {
            $primaryAgents['last_name'] = $fallbackAgents['last_name'];
        }

        return $primaryAgents;
    }
}
