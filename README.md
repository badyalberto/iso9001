Proyecto para Wip Proyecto (iso9001)


REQUEST y REPONSE

private function resjon($data){

//serializar datos con servicio serializer
$json->$this->get('serializer')->serializer($data,'json');
//sponse con httpfoundation
$response = new Response();
//asignar cotenido a la respuesta
$response->setContent('json');
//Indicar formato de respuesta
$response->headers->('Content-Type','application/json')
//devolver respuesta
 return response;
}



class User implements \JsonSerializer

public function jsonSerializer(): array{
return [
  'id' => $this.id,
  'id' => $this.id,
  'id' => $this.id,
  'id' => $this.id,
]
}
