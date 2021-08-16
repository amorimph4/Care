<?php

namespace App\Services;

class FileService
{
    private $extensions = ["text/xml"];
    private $xPath;


    public function validateExt($file)
    {
        return in_array($file['type'], $this->extensions);
    }

    public function processXml($xml)
    {
        $xml->registerXPathNamespace('ns', $xml->getDocNamespaces()[array_key_first($xml->getDocNamespaces())]);
        if (!$this->validateCnpj($xml->xpath($this->xPath.'/ns:NFe/ns:infNFe/ns:emit/ns:CNPJ')[0])) {
            return ["error" => "invalid cnpj"];
        }

        if (!$xml->xpath($this->xPath.'/ns:protNFe/ns:infProt/ns:nProt')[0]) {
            return ["error" => "not autorization"];
        }

        return [
            "sucess" => [
                "nf" =>  !is_null($xml->xpath($this->xPath.'/ns:NFe/ns:infNFe/ns:ide/ns:nNF')[0]) ? $xml->xpath($this->xPath.'/ns:NFe/ns:infNFe/ns:ide/ns:nNF')[0]->__toString() : "",
                "dataemit" => !is_null($xml->xpath($this->xPath.'/ns:NFe/ns:infNFe/ns:ide/ns:dhEmi')[0]) ? $xml->xpath($this->xPath.'/ns:NFe/ns:infNFe/ns:ide/ns:dhEmi')[0]->__toString() : "",
                "vnf" => !is_null($xml->xpath($this->xPath.'/ns:NFe/ns:infNFe/ns:total/ns:ICMSTot/ns:vNF')[0]) ?  $xml->xpath($this->xPath.'/ns:NFe/ns:infNFe/ns:total/ns:ICMSTot/ns:vNF')[0]->__toString() : "",
                "cnpj" => !is_null($xml->xpath($this->xPath.'/ns:NFe/ns:infNFe/ns:dest/ns:CNPJ')[0]) ? $xml->xpath($this->xPath.'/ns:NFe/ns:infNFe/ns:dest/ns:CNPJ')[0]->__toString() : "",
                "nome" => !is_null($xml->xpath($this->xPath.'/ns:NFe/ns:infNFe/ns:dest/ns:xNome')[0]) ? $xml->xpath($this->xPath.'/ns:NFe/ns:infNFe/ns:dest/ns:xNome')[0]->__toString() : "",
                "cod_ie" => !is_null($xml->xpath($this->xPath.'/ns:NFe/ns:infNFe/ns:dest/ns:IE')[0]) ? $xml->xpath($this->xPath.'/ns:NFe/ns:infNFe/ns:dest/ns:IE')[0]->__toString() : "",
                "end_logradouro" => !is_null($xml->xpath($this->xPath.'/ns:NFe/ns:infNFe/ns:dest/ns:enderDest/ns:xLgr')[0]) ? $xml->xpath($this->xPath.'/ns:NFe/ns:infNFe/ns:dest/ns:enderDest/ns:xLgr')[0]->__toString() : "",
                "end_nr" => !is_null($xml->xpath($this->xPath.'/ns:NFe/ns:infNFe/ns:dest/ns:enderDest/ns:nro')[0]) ? $xml->xpath($this->xPath.'/ns:NFe/ns:infNFe/ns:dest/ns:enderDest/ns:nro')[0]->__toString() : "",
                "end_bairro" => !is_null($xml->xpath($this->xPath.'/ns:NFe/ns:infNFe/ns:dest/ns:enderDest/ns:xBairro')[0]) ? $xml->xpath($this->xPath.'/ns:NFe/ns:infNFe/ns:dest/ns:enderDest/ns:xBairro')[0]->__toString() : "",
                "end_cmun" => !is_null($xml->xpath($this->xPath.'/ns:NFe/ns:infNFe/ns:dest/ns:enderDest/ns:cMun')[0]) ? $xml->xpath($this->xPath.'/ns:NFe/ns:infNFe/ns:dest/ns:enderDest/ns:cMun')[0]->__toString() : "",
                "end_mun" => !is_null($xml->xpath($this->xPath.'/ns:NFe/ns:infNFe/ns:dest/ns:enderDest/ns:xMun')[0]) ? $xml->xpath($this->xPath.'/ns:NFe/ns:infNFe/ns:dest/ns:enderDest/ns:xMun')[0]->__toString() : "",
                "end_uf" => !is_null($xml->xpath($this->xPath.'/ns:NFe/ns:infNFe/ns:dest/ns:enderDest/ns:UF')[0]) ? $xml->xpath($this->xPath.'/ns:NFe/ns:infNFe/ns:dest/ns:enderDest/ns:UF')[0]->__toString() : "",
                "end_cep" => !is_null($xml->xpath($this->xPath.'/ns:NFe/ns:infNFe/ns:dest/ns:enderDest/ns:CEP')[0]) ? $xml->xpath($this->xPath.'/ns:NFe/ns:infNFe/ns:dest/ns:enderDest/ns:CEP')[0]->__toString() : "",
                "end_cpais" => !is_null($xml->xpath($this->xPath.'/ns:NFe/ns:infNFe/ns:dest/ns:enderDest/ns:cPais')[0]) ? $xml->xpath($this->xPath.'/ns:NFe/ns:infNFe/ns:dest/ns:enderDest/ns:cPais')[0]->__toString() : "",
                "end_tel" => !is_null($xml->xpath($this->xPath.'/ns:NFe/ns:infNFe/ns:dest/ns:enderDest/ns:fone')[0]) ? $xml->xpath($this->xPath.'/ns:NFe/ns:infNFe/ns:dest/ns:enderDest/ns:fone')[0]->__toString() : ""
            ]
        ];
    }

    public function loadXml($file)
    {
        $this->xPath = preg_match("/proc/i", $file['name']) ?
        '/ns:nfeProc': '';

        return simplexml_load_file($file['tmp_name']);
    }

    private function validateCnpj($cnpj)
    {
        return !is_null($cnpj) && "09066241000884" === $cnpj->__toString();
    }
}
