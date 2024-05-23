<?php

namespace App\Services;

use App\Services\Curl;
use App\Services\RSAEncryption;
use App\Services\GetToken;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class LoginService extends Curl{

    private string $userOla;
    private string $passOla;
    private string $olaUrlBase;
       
    public  function __construct()
    {
        $this->userOla = env('OLA_LOGIN');
        $this->passOla = env('OLA_PASSWORD');
        $this->olaUrlBase = env('OLA_URL_BASE');

    }

   public function olaConsignado($values):array
   {
        try{


            $cookiePath = getcwd() . '/cookies';
            $cookieFile = $cookiePath.'/cookie_nomePadrao';
            $cookie = '';

            $user = (new RSAEncryption())->encrypt($this->userOla);
            $pass = (new RSAEncryption())->encrypt($this->passOla);
            $ip = $_SERVER['REMOTE_ADDR'];

            $ch = curl_init();
            // Primeira requisição GET para obter o token de verificação
            curl_setopt($ch, CURLOPT_URL, 'https://ola.oleconsignado.com.br/');
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, true); // Incluir cabeçalhos na resposta

            $response = curl_exec($ch);
            curl_close($ch);

            $token = (new GetToken())->getInputToken($response);

            $cookieString = $this->getCookiesString($cookieFile);

var_dump($cookieString);exit;
            $headers = [
                'sec-ch-ua: "Chromium";v="124", "Microsoft Edge";v="124", "Not-A.Brand";v="99"',
                'sec-ch-ua-mobile: ?0',
                'sec-ch-ua-platform: "Linux"',
                'Upgrade-Insecure-Requests: 1',
                'Content-Type: application/x-www-form-urlencoded',
                'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36 Edg/124.0.0.0',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
                'Sec-Fetch-Site: same-origin',
                'Sec-Fetch-Mode: navigate',
                'Sec-Fetch-User: ?1',
                'Sec-Fetch-Dest: document',
                'host: ola.oleconsignado.com.br',
                $cookieString
            ];

            $data = [
                'userIpAddress'              => $ip,
                'LoginCriptografado'         => $user,
                'SenhaCriptograda'           => $pass,
                'LoginOla'                   => 'true',
                '__RequestVerificationToken' => $token
            ];
            $postFields = http_build_query($data);
            
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://ola.oleconsignado.com.br/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_COOKIE=> $cookieString,
            CURLOPT_COOKIEFILE=> $cookieFile,
             CURLOPT_COOKIEJAR=> $cookieFile,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postFields,
            // CURLOPT_POSTFIELDS => 'LoginCriptografado=AfSF1DsxKbovKm3t0igZBif8dHr9LVoXOk89hEUj45vnJ9Mc%2BgxDtN5o5%2BY2s0oV7729gxjd6OcO1JDThKxWEV9eSfHyeFO2%2Bq9pnR%2FJ%2F%2FAoOsOYH8bOl%2F4Yjv2fBRuRtVgm71UJ%2FFe0Kre2MEVnfT%2FlvxZUcajz3kuRdgGwmt8sBnyzXz44LnTIm9heKmvx5jXDW4O0LooZtuuuhCPwLHdAFv97x%2BVmFhP3GkaWS4CR6mKHxCcyALyOOieh%2FPlAcDAei9tPjxodOChQ0I0ldvJTy9YIm65WZmsF7hUknLgKwkcLuxYK%2By8YIjo%2BZs3raIYWXFEDaAtNwlFbeSC82g%3D%3D&LoginOla=true&SenhaCriptograda=aHVeWpsIisi%2BOdITt%2BvQ0SYuRrLFXdCveyBXZzhHUrVzC9hH7RuM85DegVlfZMnNfNdnr14DOzwuXyrdAfYBAdEiTj%2BL7Fkwy2ucnqpkB%2FZU2Zqqh9BfyN4QFugjA1B37Eo8%2F82hLxzBRz8GgiRaxbigo7Qt66PsFYVMGhmbSwuncTxB1i42NCVwl62TIyUDG9VYUPQvl%2FU4JUG4sgy%2FkpvRnHfo%2F5aTeMIWq8tHRyioLW3v189obHv72WO%2BqAiWzbJqmbQUeiANBFYjjYjPdV1QX1n1Ih7k0n9oqyEW1cJX7F6msI75j%2Fbz5M4sJFnyIXKVC9BYLB1ZOU2MURaGCQ%3D%3D&__RequestVerificationToken=CfDJ8BFAi2Fz8G9PlD6865pjFJJS_tw7k6iYIsSrcmOPasR-awehi49sbvxqq6Z_GrZ0LVWfF2-g02B4NquLXGeJdTNc9xeqPoC8tHsMsb4XE8yYqfZGoQxuy-1eNaQlePL-tmsTUZvbUf7fE5DKhEGLdd4&userIpAddress=34.95.237.110',
            CURLOPT_HTTPHEADER => $headers,
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            echo $response;
exit;






            $token = (new GetToken())->getInputToken($response);




            curl_setopt($ch, CURLOPT_URL, 'https://ola.oleconsignado.com.br/');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_TIMEOUT, 0);
            curl_setopt($ch, CURLOPT_ENCODING, '');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, "CURL_HTTP_VERSION_1_1");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 100);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_POSTREDIR, CURL_REDIR_POST_ALL);
            curl_setopt($ch, CURLOPT_HEADER, [
                'sec-ch-ua: "Chromium";v="124", "Microsoft Edge";v="124", "Not-A.Brand";v="99"',
                'sec-ch-ua-mobile: ?0',
                'sec-ch-ua-platform: "Linux"',
                'Upgrade-Insecure-Requests: 1',
                'Content-Type: application/x-www-form-urlencoded',
                'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36 Edg/124.0.0.0',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
                'Sec-Fetch-Site: same-origin',
                'Sec-Fetch-Mode: navigate',
                'Sec-Fetch-User: ?1',
                'Sec-Fetch-Dest: document',
                'host: ola.oleconsignado.com.br',
                // 'Cookie: ai_user=C7qIx|2024-05-22T14:58:06.797Z; _ga=GA1.3.65535230.1716389916; _gid=GA1.3.1066230661.1716389916; _hjSessionUser_845732=eyJpZCI6IjY2NzEzMTQ5LTc0YWEtNTgwNy1iMDBhLWJmYjZhYjEyZWM3NiIsImNyZWF0ZWQiOjE3MTYzODk5MTY0NjYsImV4aXN0aW5nIjp0cnVlfQ==; .AspNetCore.Antiforgery.Y3vMx6oYCvE=CfDJ8BFAi2Fz8G9PlD6865pjFJLCsTilX_QxsOw13XSgv-bGjvs5Q6aYPpr7JBCxiw8whnlpaS_dce5ytYsQ5_RTUIXRI6g-oQphRfmJDjzUdkKSB_Sp6X0p4o2pEiPTOg8upp7oH7X0CFZ0Bx1WJUpej_Y; ak_bmsc=26EF79CA00F73C1553562CFC23AF87DF~000000000000000000000000000000~YAAQhUIVAtvxU6aPAQAAPbVOphcrQAC8kp1lS2+Xg6tQB22NyXOWfseXiBrKVwcU5AJkumMk50tp9QynPfulXulCkL4MzPrQBsTrl9uLvS7m1CxoPLjnb/9CHYVgyVRcY7WxyfYNMEHTX3YKIbbaage4EpkSe77XeSZ0ltT1njJkdJ6d/72PmRZXKsj91tuMelAdxN47Tkna7Ifhuimsszm0DVam4Y0H8NOfOniSVUMsnIqIuobjFQV38Bp35UFnOlE3o7HHhb2EFuZPEUEOUKOMOwqYHoy9QRQ0xeRZ2A1rhPHLSzt+48wz+SN0uVIAW8+s2W3OMdljFgosNiVLtFo8JEDPELCk3mri1GkDksBdjPYtgMzKCwpJ5pvi4dnbmUetKkpUhp9AhZcSdlcPnyZXp8E=; _hjSession_845732=eyJpZCI6IjcyMmI5ODVmLTEyNDYtNDQ3Ni1iYTJiLTgwMmJjYzViOThlMSIsImMiOjE3MTY0ODUwNzMwMzIsInMiOjEsInIiOjAsInNiIjowLCJzciI6MCwic2UiOjAsImZzIjowLCJzcCI6MH0=; CodigoLoja=CfDJ8BFAi2Fz8G9PlD6865pjFJIaoNLOZAqt5C1FMo2EOMUk1jK7xceVJVe0buAQCcaC8lPQ45Q9fa_ngx4NCFnsEdMCoZnWQjH618vUbKP3Dd67Ln8eIIx2_QhRHY6qCAKTbQ; NomeLoja=CfDJ8BFAi2Fz8G9PlD6865pjFJIWVyf_sik5v-XQ55wW6s22DE1LIgqxtfY4ZFIoo7Arb1As4gky4bJvF2pRhalTL2Td4ByEPrMlW2PB6k1dGumjLhPtyP3DggJk-GJ7L60cK0zF__tiFThaPu_amQktsbE; CodigoCorrespondente=CfDJ8BFAi2Fz8G9PlD6865pjFJJbvX8tdXyxhMEBzukYJjXXlnqMBlWKg3tgpEDktjxEaLvtSOu2thdZ55Or6HFleCOmhdr8MH4TrQxuVkk4Co4En9I9YWaF3DnAGaQo0y8UfA; NomeCorrespondente=CfDJ8BFAi2Fz8G9PlD6865pjFJJl5tirFkeGnxeK3Jcdo6LhFl-T9oYaG7q_YPZnLm0vkVfrJ9rg11xA88nFRUrMbmMZpUqb09pWtnMLiCikcT_s7PuFBqUETlc36_bnePU4P12VPA5d4463pFj29k-RHCo; AgenciaSantander=CfDJ8BFAi2Fz8G9PlD6865pjFJKODx9yxnSohOhKo1BmRDKHaiVZVgj1Yyi7hVTqhr1aPCG_w6xpMqxW4L0Q-cfwSykB5AlLtk68ueB5baDgdwpE2hHGWDAupU0AHxWAz-t-Eg; LojaSantander=CfDJ8BFAi2Fz8G9PlD6865pjFJKHU500gMaZp_ZtuUonXKQ3hOS_6a7d1pMxIxAiRX9aOwtQWR0_CntiCoYI7OcvGzPzfSrKmo3YT4yK5vOV8fgCl03oN-EVExIVLRbY61DIrQ; AcessoReprocessamento=CfDJ8BFAi2Fz8G9PlD6865pjFJLOkpEh-_g0cOLUU1T4s5ge03TyoMenwSGQFb7hIfz0n2yPRZOVAUXjh8CbOmTJhB_2427OB69tj3CcZPYFI9sqMySfTXsC2eta1yWeILCUcQ; CorrespondenteAcessaChat=CfDJ8BFAi2Fz8G9PlD6865pjFJJUKmm2uiZhSyWVD0yvniV7OZP819PTFAOSu7xlsnzAhfgMagB8mAaiinywP4msX9V7nI840H8PEecewBwOGjdYvaocwWA-_9cgdOHfKzNt0g; .AspNetCore.Cookies=CfDJ8BFAi2Fz8G9PlD6865pjFJKx0y-sBKTKLr-R_P744gCfgLByjYcr6BVU3yWR0_-HoMyKLd6m6JNQlZ7O9jTH35J0xZohRevdfokUKZ6O2f8yUVYkqQCt6KzRaXQ_PKuWgdGC4NeK4f7kiHdxyE254HxR0aWWYWCMf8UIrcq6mnZap0rKEcJedjg32wkVHVXdHw7Po7emenNl91YrP6zBzqCQyAmXMDe2zrCFxInn6xuKZNCdvMBZxfG0sVlXB8tMgHztfLTC2xkuM4F8OVH49S-BTlWamS1qLA1sfegYBpDXKhmO7ykccS11Tev2c0n3f0N9qmMR0ls1mDhetDKcFfvTO_PKzy6dAWen5RFF8DvD8Qpwds19YoiPF5lahNqAcRCSwH-aJqO-GJOOexw8xxaQRqiDBqIUVDIO6AjIKNSizQ51w9il8KBViCiroTAYLhiCDITXaKoA2dwoQsUOMA4Cuh8GemGdQusrjnXwX45Fbfzd_ax5sIWQl2tPNlRsovFGLZ-GQAC-5MgRt6UvxrSKeShzY6My5P1COA9kWDUdoy3sa6kvTBOrhaTorAhXawfwfMdNWeRnA-VBOO092yc9JhanBRoPwh7wJdBRqACDq-AG51fWA2-iEOAK3voZCA7TpKcRp9CEGb3Apx9Uer4jP_cLTOZHPW9KHtQZjI9Aezwo47YPxW-wbcaWydZSOiOoJ8grOXmpdLJrNp-qpsDK_blVOP9ZP0jX1ff9vuRB0etlfYooD_sDrtY-J3LbTWHud3Zfd3rlJe0wZIhC2eTuikDP8U7H5xbXRZcs5tv2XnM7n_bTiruuaOsnmQuWh4BUbVsqnbc20A75R3saTb9E5pI7t9588ikg8Ld8Wi5ITYSOG76d603xVEHTcTyHKVMNPCrS3L_XwTMndSchQcgCmJHTJqrxXFA7HadldmHeLq0nNJ0b36t-9t15zCI8WvfdkCLPE-q8qN9cCNZKjJnKKKFkzujTRcyXU_YFsKJi7OtEBECNX2pQ3ayq5lZKlWzjIoAj9dzRCIFLKxaqlik; TempoExpiracao=CfDJ8BFAi2Fz8G9PlD6865pjFJIk5UZVNC7Hr_YG6qcPSGK7LL21_iMXHxNjxlqt7S1AwRvMGeQNr1RoExKH_XoJwqZdvjcfaMtes7IJric1hWyHEPMzWG3Ei4Hx9FRA9bQUSVzVwiRD_Y7ZFuQC5cf8DzI; bm_sv=68C6756DE12F86F46D52B952283ADA50~YAAQT8QQAlgmQKSPAQAA6QqhphfumdhCICEYH2ynzbFcdr9J3d8Hbd1otqme3b2omGhFVBtKR3tYo8VKcIYYOBWT6PsmxhL6JI6BGB0cjw0qb7SavHNsEOaPo8qwUoCfnHKK6bDr5PF36HgH2ZXgUWGlhFXk+skVozydAImV2PcNqlgDdxnwnf0mPqqutLRC86jfyulY1MrgCdEVdqLEaVqi9I6OTCvX8iIuEtsqUx+ImyWcsiAu2+Lw9Cx//oAon76Poo656DKQ9JA=~1; ai_session=VszBT|1716485061023|1716487523887.7'
            ]);

            $response = curl_exec($ch);
            curl_close($ch);
            $cookieString = $this->getCookiesString($cookieFile);

            // var_dump($response);exit;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://ola.oleconsignado.com.br/');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_TIMEOUT, 0);
            curl_setopt($ch, CURLOPT_ENCODING, '');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, "CURL_HTTP_VERSION_1_1");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 100);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_POSTREDIR, CURL_REDIR_POST_ALL);
            curl_setopt($ch, CURLOPT_HEADER, [
                'sec-ch-ua: "Chromium";v="124", "Microsoft Edge";v="124", "Not-A.Brand";v="99"',
                'sec-ch-ua-mobile: ?0',
                'sec-ch-ua-platform: "Linux"',
                'Upgrade-Insecure-Requests: 1',
                'Content-Type: application/x-www-form-urlencoded',
                'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36 Edg/124.0.0.0',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
                'Sec-Fetch-Site: same-origin',
                'Sec-Fetch-Mode: navigate',
                'Sec-Fetch-User: ?1',
                'Sec-Fetch-Dest: document',
                'host: ola.oleconsignado.com.br',
            ]);

            curl_setopt($ch, CURLOPT_COOKIE, $cookieString);

            $response = curl_exec($ch);
            curl_close($ch);
            var_dump($response);exit;

            $headers = [
                'sec-ch-ua: "Chromium";v="124", "Microsoft Edge";v="124", "Not-A.Brand";v="99"',
                'sec-ch-ua-mobile: ?0',
                'sec-ch-ua-platform: "Linux"',
                'Upgrade-Insecure-Requests: 1',
                'Content-Type: application/x-www-form-urlencoded',
                'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36 Edg/124.0.0.0',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
                'Sec-Fetch-Site: same-origin',
                'Sec-Fetch-Mode: navigate',
                'Sec-Fetch-User: ?1',
                'Sec-Fetch-Dest: document',
                'host: ola.oleconsignado.com.br',
                $cookieString
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://ola.oleconsignado.com.br/ConsultaDeProposta/Index');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_TIMEOUT, 0);
            curl_setopt($ch, CURLOPT_ENCODING, '');
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, "CURL_HTTP_VERSION_1_1");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Retorna o resultado como string
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            // curl_setopt($ch, CURLOPT_COOKIE, 'ak_bmsc=8BF05189BF20013B3E4CC9D99794CB87~000000000000000000000000000000~YAAQjEIVAmE9e6aPAQAAa3GNphd3bAms2dmJRApazHtPCvKK7GqDzC1qe4iac0J97dkyyazgTBBUG0fAx7F4HoN2aH1XqsnyinUTmh+w/rHRNyaktD6K1QXto+dC7r3X8ntTb7fi5PZekWyydTKe4FdPdq6bmrtvSJM1ahLWDbQcFfI7JoM3JbI7t4BVziQz/zEjza5+17+ztP3cGXjphVvlhJ3CuGuLJ74zd7GBq4/cCmMsHLFYlMjdayShkV+BQ862Ctrleb0O+jNyHDvURSjMsRkAhLspZIA0grRfF4vHIRnblnl5Hml69u0sqOaPgw9qCmji/AcbW//4UrjFdP/1duK3JhmKwd1jVBBUQrWkVI1dmEBLWYhyzWgtZhEl8VWvINSW; bm_sv=99130D0BC36C8CD15F431DF595423748~YAAQxkIVAqi14KOPAQAAIEWephetlJJ+Bq5men8AHNxNizKTZWzmJc9J0ApSgzX70dEY524WRYZM2G8R7EercKAfP89mjx7ri6D3AJ2RC8FCWIwl2psSCmMFvkcDVZrVQluHy2ZS3/xva8wdvHWy1tLB13+NlrjVhoDW+bUaEgjs8+OczNzGJKq8EwWqPV4/wXDAanMxntJ/+6ItEiyxtumcrQuoq+t4gH1fN/rFyGrpNo007UKkiWEiW6Smw5qslq85aLoAuPtIKQ==~1; .AspNetCore.Antiforgery.Y3vMx6oYCvE=CfDJ8BFAi2Fz8G9PlD6865pjFJJsoXxpI-55u8CvNbOZP-bKQxBNbWvXD5yexdA8VXk5MQxIrCEmdws1-ezHaig6EPgL-iut4wbZKYQayr3N4NY--Qm-g3EtHt67kNpJRBaCG2eIfWfCuFTCew6qHPmIuGY; .AspNetCore.Cookies=CfDJ8BFAi2Fz8G9PlD6865pjFJIOB5QBRRD3UW4cZMNh01byS6wx6c6Cm-I5Ix7HODzYeytV8T-8hJRDhYq3kRg8R53P7Fdl2SqowFuQb0hKtzxsJQ8nyakePXRqELpV1Be5zjRcxzOJebu_axgeYZSk6DeM9lP28VFq-FFEpS5ggiYaN2FfsGevUce6qPsOCEYYUsfE4DQu_vaRrl7XNhvKRgQpxz6-OCc1cNQ2_xI4FAskhyyQsXYFLmnsYjHgy_nMi9A2rKn4EpKxYB5k8zYQJ2VMTjo6iR0ZXxA6WN_da_ez380kI_IDNF48BauFW4Bd2kh_6Q0AfJ8p9CfSiLayWnZdt0_LqjE4ut1wbmQkXuz11OwZNYe-DlLAS-D1hxTCqQHj-d98WxkT0iHiVbax7Ssg9tzf5iIbBOYcmZa8oCFiucMPCFMyZP_IFRZCDFqu1kyhx9wR06C_DGP6zp4YN-DFYJeOau1_4h_qdVTI7lmkS-FxCccKYfwKvWjWI9LQxTmzZR7l_6terS6LJACCrM3cXRRn7rLA04APJO2rnfIsmz27t-1otbuiq_Lb5L8cU8ilSlC8-mCgIQtEXqVWSf2mz74xa7FTBs0_WFWq2p2HyvDnbbYlhNDCszSFjlzzuZwJTEMVCuJLuF9l_9YAQ-FJbjTQDIzcKX1j9rqBJY19ne1ZVm7nwghOSl3UYiLUlRQWJXo3uoZsh8KrH60RJ0VJ_mirs3SYUBR65_6obyrGxTITCZJtdI1cJCLDP6hiyOes67TDHPV4LI6IGH0D_Y_8XBmVqT3BWdxlNEyWJx9IuH-OG82KhQeVr9jD1Ej0lzfxM98ZrM5oOUiG-zkb7pa6O-qSpgz2XEPPsAAAwC-OwOz-403PwZi838vcRXhiSmsfBRxVpGiCKl1trK8pglGc4njhG3Qzo0_SKWaIYLuHHCtJzmDWDs6Qm1PCYAacKbWzgqW-Wa692CMXFvW-2n-0zItEV2upwDtmjLKJbukq0ksTAbJaq5VDbIdNhQZ-DvSDvxOYajOxiILksRsjK24; AcessoReprocessamento=CfDJ8BFAi2Fz8G9PlD6865pjFJLcJvGaex7Pr5o5k2_VvRWLMLC0c95S33fIUfNHQb71q4JskIWnqzPqeQvxdnUFhqa_gaENs2HX_Iq6ukL-jsO6Ahm_qLTq-U-LQylmO_vq-w; AgenciaSantander=CfDJ8BFAi2Fz8G9PlD6865pjFJLmThANCjgzttm_qt67hvU1svt2VmnLT_i6Dv1JzaInnPnthzkodUT0_O3GxdxQXtsF35ObMbaCs9NX-3xa5Tw6-OrBNy70tt7e_vwF-WOAvg; CodigoCorrespondente=CfDJ8BFAi2Fz8G9PlD6865pjFJI13w2Vri5JxxYlFg7E-a5-y8d0Nfg0N-rD12kOzBZivg1RrdOsh6CViwQuKOXJQs3R_VgggdUk-YXgxXdbiZKemSJ4W9JVEjlB0hmRJhy2cA; CodigoLoja=CfDJ8BFAi2Fz8G9PlD6865pjFJIc04Yl5rVZUseLbF95eAs-LWP78S1QUJzDk6F3w7ekrQNoH2giHaq_Nsip5lKIdpYE_umH8ZysNr-hU6DancjO0lsU5A4RXH0PkJ_etguojA; CorrespondenteAcessaChat=CfDJ8BFAi2Fz8G9PlD6865pjFJJ_1BW-In_u3DDYQKIC_1mSQbYw5w7XuyBuCeE8e0qzAP3feQENCln0G8HmWDMpOAgyQVPWOQ93JLaiOXxNYp--wYQrmMLa3W-y3xZFNNUcQg; LojaSantander=CfDJ8BFAi2Fz8G9PlD6865pjFJKoGfoWAZ3lUBOejeI_lIjy8CSQywlH-uLcuXyPfCfITq507AZ41ncagfVW-VTAG3I8xphvvtONy2pRoU8JE_sgaIRzxEnonNkv9mdmyHYWxA; NomeCorrespondente=CfDJ8BFAi2Fz8G9PlD6865pjFJKhmIBIdAy-nOrofo-ty1x9MjUmYrCz0vhesi0Hcl2Q_Sx2NF9bbH8D7zk2UkbzRWzy_a3GRN2E8Q-w8FMS8UvsOzCMlOhT0zrpn_mvTDld5ZB0CzP-x1tFakqKLweGhUk; NomeLoja=CfDJ8BFAi2Fz8G9PlD6865pjFJK04EnRQRdfj0uiyDuqQysFTkUe_3VShmvTUXoJSPjvUKctDOzIMLFvmUndLJPWhBcZ3-8i0ButD9Yt-4gHdBV7SE3W6EJ-zCAXOmPeW1UoatrcCDEsKauI_MopUC9uuew; TempoExpiracao=CfDJ8BFAi2Fz8G9PlD6865pjFJLZv0itvGe-Mk8488RwaH-3fkZ6PIkBtOw6clpHRI-S36uS9s27u7kow-IN2ZehcbEFKyEwcxDleEanlNllqN-y22F1IbtOnvlzkm0bRTem5hKCRJSuvmBxc3L0Vbr6s18');
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_COOKIE, $cookieString);

            $response = curl_exec($ch);
            curl_close($ch);
            var_dump($response);
            
            exit;
            var_dump($user);
            var_dump($pass);
            var_dump($ip);
            var_dump($token);

            exit;



            $loginData = [
                "LoginCriptografado" =>  $user,
                "SenhaCriptograda"   =>  $pass,
                "LoginOla"           => true,
                "userIpAddress"      => "34.95.237.110",
                "__RequestVerificationToken" => "CfDJ8BFAi2Fz8G9PlD6865pjFJKVP2BBNqknULjOZoSbykTWQttz79mqcsMW9PKQoIqqlm9mNwxnkwR53NJJ6Pm9WVr7B_pnCXOoVDwQ3yNo6RftUuen7AmnfR_s8mN1ZiBU7YTHefsSiwTbaV6sM3hnHlQ",
            ];
            $queryString = http_build_query($loginData);


            var_dump($response);
            

            exit;
//             $cookiePath = getcwd() . '/cookies';
//             $cookieFile = $cookiePath.'/cookie_'.date('Y_m_d_H_i_s');
//             $cookie = '';

            
//             $ch = curl_init();
//             curl_setopt($ch, CURLOPT_URL, 'https://ola.oleconsignado.com.br/');
//             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//             curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
//             curl_setopt($ch, CURLOPT_HTTPHEADER, [
//                 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
//                 'accept-language: pt-BR,pt;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6',
//                 'cache-control: no-cache',
//                 'pragma: no-cache',
//                 'priority: u=0, i',
//                 'sec-ch-ua: "Chromium";v="124", "Microsoft Edge";v="124", "Not-A.Brand";v="99"',
//                 'sec-ch-ua-mobile: ?0',
//                 'sec-ch-ua-platform: "Linux"',
//                 'sec-fetch-dest: document',
//                 'sec-fetch-mode: navigate',
//                 'sec-fetch-site: none',
//                 'sec-fetch-user: ?1',
//                 'upgrade-insecure-requests: 1',
//                 'user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36 Edg/124.0.0.0',
//             ]);
//             curl_setopt($ch, CURLOPT_COOKIE, $cookie);
//             curl_setopt($ch, CURLOPT_COOKIEFILE, $values['cookieFile']);
//             curl_setopt($ch, CURLOPT_COOKIEJAR, $values['cookieFile']);

//             $response = curl_exec($ch);
// curl_close($ch);

//             // var_dump($response);
//             libxml_use_internal_errors(true); // Suprimir erros de parsing
//             $doc = new DOMDocument();
//             $doc->loadHTML($response);
//             libxml_use_internal_errors(false);
            
//             $tags = $doc->getElementsByTagName('input');
//             $token = null; // Inicializar a variável do token
            
//             foreach ($tags as $tag) {
//                 if ($tag->getAttribute('name') == "__RequestVerificationToken") {
//                     $token = $tag->getAttribute('value');
//                     break; // Saia do loop assim que o token for encontrado
//                 }
//             }

            // $encryptedUser= (new RSAEncryption())->encrypt($this->userOla);
            // $encryptedPass= (new RSAEncryption())->encrypt($this->userOla);

            // var_dump($encryptedUser);
            // var_dump($encryptedPass);
            // var_dump($token);
        
            // exit;
           
            $loginData = http_build_query($loginData);
var_dump($loginData);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://ola.oleconsignado.com.br/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => 'LoginCriptografado=YJNur9rHXsOh6Nf8Ljp%2FTBVHCeaxOIJiu%2BOMAW1V68A5aW0JU2bm5eAeuuvTsdOVVKyMJfAZnWja4p88Es5Tp45ZbHUhvDHal488RPevPf5%2FvGRU0ib5zQNwCg1Kg%2FkVDOex3S0VIY5hD3iRQM9mLEm9RHzmkxpCRoNQAfjy3OgdswMVhTNiD%2BQ5gtq1%2BT9HLDmFJMoGKe8m2GBqP8JHU%2F%2Fd0C4XSJnxdBJmLbOYn6vfc5eWXbEPINDng0cOsS%2BgeZ19kB%2BWqqNBuEPzAMNom4rsKgidTPo1N0qnyvBtgewtQ%2F5KlPzQlR68FkzNrni0zYQhkQF2IB8HipDj9MKChQ%3D%3D&LoginOla=true&SenhaCriptograda=HHsF%2B3Q%2BuEYwd%2B5Ym7Y54fVvz0hxkXHbdxeyaF27tQV%2FKPQkW1jfLO5tdq0PjJ6NCKLpTPprwEe81guq9Um49yBqHuP%2FdBaujRRGw9MA1O0ACU%2FGqeUtN6A9HhScLwwECMo3IXIDj%2FVG6NuHG0fkPrrr%2FkHny9mbYQDO%2BnybFKZNwVT1sNcZIWyyvI3bbzZVYR1ZGsH22hshigsdD6iZOCiWoXPTwAG6dEmQBmXcoAtslQ4hqeBgzxJmcdUs%2BliHDY922f7U4bdmJyL1LBg48TdhcyWVGhoTSruIVutPsADJ97N2MSxP2O%2BxxH3Ul64K9yk3IOxAWsZWzjwH1%2Fno1Q%3D%3D&__RequestVerificationToken=CfDJ8BFAi2Fz8G9PlD6865pjFJKVP2BBNqknULjOZoSbykTWQttz79mqcsMW9PKQoIqqlm9mNwxnkwR53NJJ6Pm9WVr7B_pnCXOoVDwQ3yNo6RftUuen7AmnfR_s8mN1ZiBU7YTHefsSiwTbaV6sM3hnHlQ&userIpAddress=34.95.237.110',
  CURLOPT_HTTPHEADER => array(
    'sec-ch-ua: "Chromium";v="124", "Microsoft Edge";v="124", "Not-A.Brand";v="99"',
    'sec-ch-ua-mobile: ?0',
    'sec-ch-ua-platform: "Linux"',
    'Upgrade-Insecure-Requests: 1',
    'Content-Type: application/x-www-form-urlencoded',
    'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36 Edg/124.0.0.0',
    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
    'Sec-Fetch-Site: same-origin',
    'Sec-Fetch-Mode: navigate',
    'Sec-Fetch-User: ?1',
    'Sec-Fetch-Dest: document',
    'host: ola.oleconsignado.com.br',
    'Cookie: ak_bmsc=EA84A9004524520A2752AEFF60AB6A10~000000000000000000000000000000~YAAQhUIVAvX/PZaPAQAAlhXLnBcu8P9tpRt3LjnuFPUtCo9qhOuS+WT22e8ZUU7nm3b9vdOIHepTQlZ5KrD91c9nADpCSNMu/XK5RJdxROUmCw8JMsK933cHVLU0NgsMFNKdP99JhAin+B90Wv+FlVskK1w6fqIU/PF+qHaWJHpSBm1WSaSbAXGmDsiOY6YUoM/2IQigyMt9rZHvsZqY/5HZSLMdH6/eWRbFpPKRJ54u01t9bNifE/A/k5FVoAWnru/O77wwaQ+CKx6pFHxBhtqALVeQun/V/LVCbmZXZVnK/uUr1FA2Am6BI/cH+lOPBZZ00wdOEcW7ILFDgtvpfQOV5QAodQeuaV3d9/nbLZ9MOPA+b5dVmqW0frJw9dmcqr7KFrMz; bm_sv=195251BA291535BBEA60E3334EA48D8F~YAAQhUIVAqvmRpaPAQAAxK3SnBd5uUaNJBWQ/DcVkidyvyk+ytIurfV8ZYZ/rmHWgffCMWFp2RPe+dcPPL2EQxxG/kgjlHJ3EOW1l2JS9nfNt6JUkxKnQTxYwkwpVjsB5Fxu/C/ntdu5e2cfpJIEUPw/nCnJIb2yfzZ8nNCn54G3rYaFlWsCsp1/5mUmYSalonjx7dlHC0jKlzZHmYeVzTrt2Mkdk1PvKXGPiRgCmOKrXq4prFYwnryK96UKIceSoCPaAJ1C5xa5Nw==~1; .AspNetCore.Antiforgery.Y3vMx6oYCvE=CfDJ8BFAi2Fz8G9PlD6865pjFJK2tnf_xdHvqJkpicsztM2AanOnQMMg4CSVuWtgXquwhk83vZA-h0I4ba3FX6NsNoiT144piyDRwhvo57t3DoWsDkGkqKfwTZShSU6VIkW1LXpZOc5h9wP9HIiii5I3kB4; .AspNetCore.Cookies=CfDJ8BFAi2Fz8G9PlD6865pjFJL2GhjsgLWCIBVY4N13jrVrOrI-MSX2-vzYaGFSG-HGXiE0ZqQg2H4UR1vSJgKNeUo3MP4tj8okgDdZRjFbBbmxC8KqSGj6JC1YRR-T_l-6sJqrRjhTZe02MWGhbn50uC0goWccttb19NCJMACxeva66zfwa2hU54a6cGw7wshOIpoyYL44Pk80jNxaoLLYHth_WKZlCOt8FI6lgb7w1LM4abwekvrARn_BgKVothK31ksY_kXZj_NLoIPuBkNCC0wlsp8QBSqUd3w-0SfxGppt7d6MoNvQlcXCma5ZD0fL9XWKtRwgeRKYMlF3-ngonnhvHtdNL1lPaEcNeJ-IJcSU96JYfZnTNJ_Pl7KKg_rUXIfZ1S0gGrMOOLxOVxrs7MKnwiGdm2FnLuPd5nLUZU49mYJ8My3t8InUvkjL0FKWSexyfHypU4MZdcNCLiTlzswq5QNR3TTZ9QOm5msMH9KCmsTa_1L8huKrfOSh7feztCT4hq4q5uY2DUlPUNFCpE_q30QIo2vJQ1qacwbrR6kL5Ecd86DANP1yZSjwpb6IpwM44D8X5pDk3Yw9Ckbq8cxotM5YhLjHcBhct6OTm70a5O3ezi5NBk476-n_N_GgBENp_UQuYHZC7gSZUe3WfG3swDhGjH9IaPiMi24V9I_0w6nscM9CXBVUCcLMrp2EYUkmqG2ePWv5qkyVspP5Q2Gnmej9MXG2LGHaRr1AcJNTRwzsRjmv4lrYlVnyGPJNfg0Asyce25Gkkacvk3Q3fuYOXkrzm10w7j95iyTZln-mAdwQKZP7SjxhAIoYCmIDEA63FNd7E98tMk4xzOHf41umkU-18ENPO8BN2ajOVtwdKRJzd_D4-H10z5u3Yrd941G5iWjlMcdnxgZl-PAZC83Dau_8IuS85FAkef9seYs-oktckMTE1nJrCE06tMtus1pAbdwKdBwCVTNO8_1jA59Wde3Udp4BKEjSqArnQ2TjTXHsGdsyIn-wEVVv0-gpbIxUQSKcPB_oh9q0slNA2Xs; AcessoReprocessamento=CfDJ8BFAi2Fz8G9PlD6865pjFJJJl6jmmaGpWyK5yCUZvc8JV0Gm9ejrxP7KhqkETgTKQkKGb4IGOIDBnPcV9A8dE0XGXsjqZH73ne6KbeBLzOqzAu9GsarCSC7TQXJlbRSmJg; AgenciaSantander=CfDJ8BFAi2Fz8G9PlD6865pjFJLd8cz-DUIeII8Hwaj5bKSpXFxDY9mh2OBfcpFWZ_z48hX_uzMgFhJEDHVJELDSuukUhl-WRZsirh5N4NdtXYS-WIzcaZUU8SYpsmJkEBwOPg; CodigoCorrespondente=CfDJ8BFAi2Fz8G9PlD6865pjFJLgXJJJVIbK2j_agrNp0j48J8WJxhAUQvv9SrpG7vWDtBoL2-QxeqaZsrSl5TkDTAJ0LViRRiWBe31ss_WADNDtsaj_e65VlP54SLOMRUdQ5w; CodigoLoja=CfDJ8BFAi2Fz8G9PlD6865pjFJJ6S9VvHXO2QBjBfUAcXvIb0sucKR0LurepICakAwVTHvDiB7iqiAL7mnqSsBZyc5xRhAhkVtRI3E4HWG2Wyf_9v3eXrNT_DU_UI_FUJyZ0zw; CorrespondenteAcessaChat=CfDJ8BFAi2Fz8G9PlD6865pjFJLfQA_nClvpFTkVFMYVfKe1XFLbtoW-QoXuJ32ZZCq4ubRFyPC6GkIMjfbXnvuDx0hMFuu2RUZGbxy6a-YFhqfa5OEHB4Sb3sxqyzgsJg-V8Q; LojaSantander=CfDJ8BFAi2Fz8G9PlD6865pjFJKyx6RQjN3WDnGbfuBzvE6puuNPezJ4AjZRBCjCfV_d8AlvT4-5PvtZVWqct3FAPfLLDx9Aq8gqeRadr64E3uUeF-xDTj7RrqXXbamDST9_TQ; NomeCorrespondente=CfDJ8BFAi2Fz8G9PlD6865pjFJLrAIg3eC2PR9d_mjPkVdvu4nyUsLmh0r7_QC0uRyv07fKcJZ_IsiiRpydq4NEHtS-0OKw7kkPbJ6_sYxr4tZ61xoJq5Jrb_yGme9tdeNXuJcQ3Hlza62Qxlb5-y1qc-sc; NomeLoja=CfDJ8BFAi2Fz8G9PlD6865pjFJJBDpO7R9mk5OtTb5y9-B8NwAe0YBe1hrS-qyqBN3jmQtuDPrbOS6CV5sTIou55-BRXvWlscTdgmnGtKrcCVoF6sZsYMdRXO9dwkkaXfZKzwzpZ6UkLqxQhHwjdUzhLB18; TempoExpiracao=CfDJ8BFAi2Fz8G9PlD6865pjFJJWUaCAQAYSHxdyicWfMDESoLuXi8_omR_9oXw-PsTKIu4aZIRVMYtj8cyTLwZhzdXyM4XIy9GTV9mkOhsHIklnmTucZLmhi37MrnTFa9XH0gX3VSs8t5mqkZ1DFWtp3WI'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

            exit;
            // curl_close($ch);

            var_dump($response);exit;

            return [
                "erro"       =>  false,
                "response"   =>  "teste",
            ];

        }catch (\Exception $e){
                return [
                "erro"     =>  true,
                "response" =>  $e->getMessage()
            ];
        }
    }
}