<?php

if (!isset($_SESSION)) {
    session_start();
}

$contArquivos = 0;

$caminhoArquivosIniPt = (__DIR__ . "/../../applications/system/lang/portugues-brasil/");
$caminhoArquivosIniEn = (__DIR__ . "/../../applications/system/lang/english/");

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

$_SESSION['msg'] .= "<br><p class='p-green'>" . $contArquivos . " arquivos foram criados!</p>";

header("Location: index.php");
