<?php

namespace App\Services;

class Curl
{
    public function getCookiesString($cookieFile) {
        // Verifica se o arquivo existe e lê seu conteúdo
        if (!file_exists($cookieFile)) {
            throw new Exception("Arquivo de cookies não encontrado: $cookieFile");
        }
    
        $cookieData = file_get_contents($cookieFile);

        if ($cookieData === false) {
            throw new Exception("Falha ao ler o arquivo de cookies: $cookieFile");
        }
    
        // Divide o conteúdo em linhas
        $cookieLines = explode("\n", $cookieData);
        $cookies = [];
    
        foreach ($cookieLines as $line) {
            // Ignora linhas de comentários e linhas vazias
            if (strpos($line, '#') === 0 || trim($line) === '') {
                continue;
            }
    
            // Divide a linha em partes com base em tabulações
            $parts = explode("\t", $line);
    
            // Obtém o nome e o valor do cookie (ajustando para garantir que há partes suficientes)
            if (count($parts) >= 7) {
                $name = trim($parts[5]);
                $value = trim($parts[6]);
                $cookies[$name] = $value;
            }
        }
    
        // Constrói a string de cookies
        $cookieString = 'Cookie: ' . implode('; ', array_map(
            function ($key, $value) {
                return "$key=$value";
            },
            array_keys($cookies),
            $cookies
        ));
    
        return $cookieString;
    }
    

    protected function get(array $values):array
    {

        try{
            $ch = curl_init($values['url']);

            if(isset($values['urlCaptcha'])){
                curl_close($ch);
                $ch = curl_init($values['urlCaptcha']);
            }

            if(isset($values['headers']) && !empty($values['headers'])){
                curl_setopt($ch, CURLOPT_HTTPHEADER, $values['headers']);
            }

            if(isset($values['method']) && !empty($values['method'])){
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $values['method']);
            }

            if(isset($values['formDataString'])){
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $values['formDataString']);
            }
            
            if(isset($values['cookieFile'])){
                curl_setopt($ch, CURLOPT_COOKIEFILE, $values['cookieFile']);
                curl_setopt($ch, CURLOPT_COOKIEJAR, $values['cookieFile']);
            }

            if(isset($values['cookie'])){
                curl_setopt($ch, CURLOPT_COOKIE, $values['cookie']);
            }

            if(isset($values['followLocation'])){
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_MAXREDIRS, 100);
            }

            if(isset($values['urlRefer'])){
                curl_setopt($ch, CURLOPT_REFERER, $values['urlRefer']);
            }
            
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_VERBOSE, true);

            $response = curl_exec($ch);
            $info = curl_getinfo($ch);

            if(isset($values['debug']) && $values['debug'] == true){
                var_dump($info);
            }
            // var_dump($info);

            curl_close($ch);

            return [
                "status"    =>  true,
                "response"  =>  $response
            ];

        }catch(\Exception $e){
            return [
                "status"    =>  false,
                "response"  =>  $e->getMessage()
            ];
        }
    }
}
