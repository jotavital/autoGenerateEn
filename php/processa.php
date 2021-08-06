<?php

if (!isset($_SESSION)) {
    session_start();
}


$caminhoArquivosIniPt = (__DIR__ . "/../../applications/system/lang/portugues-brasil/");
$caminhoArquivosIniEn = (__DIR__ . "/../../applications/system/lang/english/");
$pastaAdmin = __DIR__ . "/../../applications/system/admin/";

if(isset($_POST['gerarEn']) && $_POST['gerarEn'] == "true"){
    $contArquivos = 0;
    
    $files = glob($caminhoArquivosIniPt . '*.{ini}', GLOB_BRACE);
    
    if (is_writable($caminhoArquivosIniEn)) {
    
        $_SESSION['msg'] .= "<br><p class='p-green'>O diretório lang/english tem as permissões necessárias!</p>";
    
        foreach ($files as $file) {
            if (copy($caminhoArquivosIniPt . basename($file), $caminhoArquivosIniEn . basename($file))) {
    
                $nomeArquivoIniEn = "en_" . explode("pt-br_", basename($file))[1];
    
                if (rename($caminhoArquivosIniEn . basename($file), $caminhoArquivosIniEn . $nomeArquivoIniEn)) {
                    $_SESSION['msgDetalhado'] .= "<br><p class='p-blue'>Arquivo " . $nomeArquivoIniEn . " criado com sucesso!</p>";
                    $contArquivos++;
                } else {
                    $_SESSION['msgDetalhado'] .= "<br><p class='p-red'>Erro ao criar arquivo " . $nomeArquivoIniEn . "!</p>";
                }
            } else {
                $_SESSION['msgDetalhado'] .= "<br><p class='p-red'>Erro ao criar arquivo " . $nomeArquivoIniEn . "!</p>";
            }
        }
    } else {
        $_SESSION['msg'] .= "<br><p class='p-red'>O diretório lang/english NÃO tem as permissões necessárias!</p>";
    }
    
    $_SESSION['msg'] .= "<br><p class='p-green'>" . $contArquivos . " arquivos EN foram criados!</p>";
}


if(isset($_POST['gerarPt']) && $_POST['gerarPt'] == "true"){
    $contArquivos = 0;

    $files = glob($pastaAdmin . '*.{php}', GLOB_BRACE);
    
    if (is_writable($caminhoArquivosIniPt)) {
    
        $_SESSION['msg'] .= "<br><p class='p-green'>O diretório lang/portugues-brasil tem as permissões necessárias!</p>";

        
        foreach ($files as $file) {
            $nomeArquivoIniPt = "pt-br_" . explode(".php", basename($file))[0] . ".ini";

            if (!file_exists($caminhoArquivosIniPt . $nomeArquivoIniPt)) {

                $arquivoPtCriado = fopen($caminhoArquivosIniPt . $nomeArquivoIniPt, "w");

                if ($arquivoPtCriado != false) {
                    $_SESSION['msgDetalhado'] .= "<br><p class='p-green'>Arquivo " . $nomeArquivoIniPt . " criado com sucesso!</p>";
                    $contArquivos++;
                    fclose($arquivoPtCriado);
                } else {
                    $_SESSION['msgDetalhado'] .= "<br><p class='p-red'>Erro ao criar arquivo " . $nomeArquivoIniPt . "!</p>";
                }

            } else {
                $_SESSION['msgDetalhado'] .= "<br><p class='p-red'>Arquivo " . $nomeArquivoIniPt . " não foi criado pois já existe!</p>";
            }
        }
    } else {
        $_SESSION['msg'] .= "<br><p class='p-red'>O diretório lang/portugues-brasil NÃO tem as permissões necessárias!</p>";
    }
    
    $_SESSION['msg'] .= "<br><p class='p-green'>" . $contArquivos . " arquivos PT foram criados!</p>";
}

header("Location: index.php");
