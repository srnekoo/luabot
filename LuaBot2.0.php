<?php
$request = new HttpRequest();
$request->setUrl('http://v4.chatpro.com.br/chatpro-lf37t5d95b/api/v1/send_message');
$request->setMethod(HTTP_METH_POST);

$request->setHeaders(array(
  'cache-control' => 'no-cache',
  'Authorization' => 'u98mxxn9n5rp0wdqtvdjp5dphdp683'


));

//ESTOU RECEBENDO A MENSAGEM E A MENSAGEM É DO TIPO CHAT
if( ($data['messages'][0]['fromMe'] === false) && ($data['messages'][0]['type'] == "chat") ) {
	
	$nome = $data['messages'][0]['senderName'];
	$phone = explode("@", $data['messages'][0]['chatId'])[0];
	$body = $data['messages'][0]['body'];
	
	if(status_conversa($phone)) {//COM CONVERSA
		
		if(strtoupper($body) == "1") {
			salva_historico($phone, '', '', 'opção 1 selecionada', '001');
			if(verifica_cliente($phone)){
				salva_historico($phone, '', '', 'Texto enviado', '003');
				$message = $nome."*Bacana, vou te explicar tudo direitinho mas me diga qual o seu talento?* /nExemplo: Vocal e Violão";
				enviar_mensagem($phone, $message);
			} else {
				salva_historico($phone, '', '', 'Solicitamos o nome do cliente.', '002');
				$message = "Notamos que você não esta cadastrado em nosso sistema, por favor, nos informe o *seu nome:*";
				enviar_mensagem($phone, $message);
			}
		}
			
			$ultimo = ultimo_codigo($phone);
			switch($ultimo) {
				case 2:
					$name = $body;
					salva_historico($phone, '', '', 'Capturamos o nome do cliente.', '004');
					cadastra_cliente($name, $phone);
					
					salva_historico($phone, '', '', 'Texto enviado', '003');
					$message = $nome."*Bacana, vou te explicar tudo direitinho mas me diga qual o seu talento?* /nExemplo: Vocal e Violão";
					enviar_mensagem($phone, $message);

					break;
				case 3: 
						$talento = $body;
						salva_historico($phone, '', '', 'Talento inserido', '005');
						cadastra_cliente($name, $phone, $talento);

						salva_historico($phone, '', '', 'texto enviado', '006');
						$message = "Tranquilo, você é solo ou tem mais integrantes? /n*1* - Solo /n*2* dupla/banda";
						enviar_mensagem($phone, $message);

				case 6:
					$integrantes = $body;
					salva_historico($phone, '', '', 'numero de integrantes inserido', '007');
					cadastra_cliente($name, $phone, $talento, $integrantes);

					salva_historico($phone, '', '', 'texto enviado', '008');
					$message = "Entendi, muito legal! 😁";
					enviar_mensagem($phone, $message);

					salva_historico($phone, '', '', 'texto enviado explicação', '009');
					$message = "Bom, nós da Produtora ÁZ temos muitas parcerias e influência em eventos e editais da prefeitura e estamos selecionando perfis com potencial para direcionarmos para vagas, também temos assessoria total para o artista e sua imagem social, gravação de estúdio, vídeo clipe e editora, suporte para os escritores como métrica da letra e parâmetro musical e também todas as questões burocráticas como direito autoral, registro de fonograma, criação da ISRC e afins. Resumindo, estamos bem preparados para realizar sua carreira de sucesso 🤩";
					enviar_mensagem($phone, $message);
				
					salva_historico($phone, '', '', 'texto enviado explicação', '010');
					$message = "Atualmente estamos precisando expandir nosso portfólio de artistas e completar vagas e é aqui que precisamos de você, para isso precisamos passar por uma audição. ";
					enviar_mensagem($phone, $message);

					salva_historico($phone, '', '', 'texto enviado endereço', '011');
					$message = "Nosso endereço é *Rua Anita Garibaldi,n° 1121* /nEd. TAllahassee /n*Produtora ÁZ*";
					enviar_mensagem($phone, $message);

					salva_historico($phone, '', '', 'texto enviado agendamento', '012');
					$message = "*Teria interesse em agendar um horário?* /n*1* - Sim /n*2* - O que é uma audição?";
					enviar_mensagem($phone, $message);
					
						break;
				case 12:
					if($body == "1") {
					salva_historico($phone, '', '', 'opção 1 selecionada', '013');

					salva_historico($phone, '', '', 'texto enviado agendamento', '014');
					$message = "*Muito bom, qual dia seria melhor?*";
					enviar_mensagem($phone, $message);
					
					if($body == "2")
					salva_historico($phone, '', '', 'opção 2 selecionada', '015');

					salva_historico($phone, '', '', 'texto enviado audição', '016');
					$message = "Audição funciona como uma conversa, assim conhecemos melhor sobre o artista e seu talento. Se possuir alguma demonstração audio, video ou até mesmo uma papinha ao vivo é muito bom para termos uma analise melhor. Bem simples né? E não tem nenhum custo. *Tem interesse em agendar um horário?* /n*1*- Sim /n*2*- Não, obrigado";
					enviar_mensagem($phone, $message);
					} else {
						$message = "Você enviou uma opção inválida, tente novamente digitando só a opção. /nExemplo: 1";
						enviar_mensagem($phone, $message);
					}
					break;
				case 16:
					if ($body == "1") {
						salva_historico($phone, '', '', 'texto enviado data', '014');
						$message = "*Muito bom, *qual dia seria melhor?* /nExemplo: 29/04";
						enviar_mensagem($phone, $message);
						}

					if($body == "2"){
								salva_historico($phone, '', '', 'opção 2 selecionada', '017');
								salva_historico($phone, '', '', 'texto enviado agradecimento', '018');
								$message = "Tudo bem, agradeço o contato, se mudar de ideia pode me chamar aqui. Boa semana! 😁";
								enviar_mensagem($phone, $message);

					} else {
						$message = "Você enviou uma opção inválida, tente novamente digitando só a opção. /nExemplo: 1";
						enviar_mensagem($phone, $message);
					}
					break;
				case 14:
					$dia = $body;
					salva_historico($phone, '', '', 'data inserida', '019');
					cadastra_cliente($name, $phone, $talento, $integrantes, $dia);

					salva_historico($phone, '', '', 'texto enviado horario', '020');
					$message = "Agora o horário, estamos disponiveis a partir as 10:00 até as 20:00. *Qual horário seria melhor pra você?* /nExemplo: 14:30";
					enviar_mensagem($phone, $message);

					break;

				case 20:
					$horario = $body;
					salva_historico($phone, '', '', 'horario inserido', '021');
					cadastra_cliente($name, $phone, $talento, $integrantes, $dia, $horario);

					salva_historico($phone, '', '', 'texto enviado instagram', '022');
					$message = "Beleza, *agora eu preciso de teu Intagram*. /nExemplo: @_amorimbusiness";
					enviar_mensagem($phone, $message);

					break;

				case 22:
					$instagram = $body ;
					salva_historico($phone, '', '', 'Intagram inserido', '023');
					cadastra_cliente($name, $phone, $talento, $integrantes, $dia, $horario, $instagram);

					salva_historico($phone, '', '', 'texto enviado confimação', '024');
					$message = "Tudo certo, vou mandar o resumo do seu agendamento:/n*Nome:*$name / $instagram /n*Numero:*$phone /n*Data*:$dia ás $horario /n*Talento:*$talento / $integrantes /n*Produtora ÁZ* /n*Rua Anita Garibaldi,n° 1121*";
					enviar_mensagem($phone, $message);
					salva_historico($phone, '', '', 'texto enviado confimação', '025');
					$message = "Agendei seu horário, se possível chegar 5 minutos antes nós agradecemos. Em caso de atraso ou cancelamento, entre em contato. /n*Precisa de mais alguma coisa?* /n*1*- Não /n*2*- Outras informações" ;
					enviar_mensagem($phone, $message);

					break;
				
				case 25:
					if($body == "1") {
						salva_historico($phone, '', '', 'texto enviado finalização', '026');
						$message = "Agradecemos muito seu contato. Tenha uma ótima semana! 😁";
						enviar_mensagem($phone, $message);
						
					} if ($body == "2") {
						salva_historico($phone, '', '', 'texto enviado informaçoes', '027');
						$message = "*Sobre o que você quer saber?* /n*1* - O que é Amorim Business? /n*2* - Preciso cancelar/reagendar meu agendamento /n*3* - Preciso levar algo? /n*4* - O que eu faço quando chegar no endereço? /n*5* - Redes sociais /n*6* - Outra pergunta";
						enviar_mensagem($phone, $message);
					} else {
						$message = "Você enviou uma opção inválida, tente novamente digitando só a opção. /nExemplo: 1";
						enviar_mensagem($phone, $message);
					}
					break;

				case 26:
					if ($body == "2") {
						salva_historico($phone, '', '', 'texto enviado informaçoes', '027');
						$message = "*Sobre o que você quer saber?* /n*1* - O que é Amorim Business? /n*2* - Preciso cancelar/reagendar meu agendamento /n*3* - Preciso levar algo? /n*4* - O que eu faço quando chegar no endereço? /n*5* - Redes sociais /n*6* - Outra pergunta";
						enviar_mensagem($phone, $message);
					} if (strtoupper($body) == "Outras informações") {
						salva_historico($phone, '', '', 'texto enviado informaçoes', '027');
						$message = "*Sobre o que você quer saber?* /n*1* - O que é Amorim Business? /n*2* - Preciso cancelar/reagendar meu agendamento /n*3* - Preciso levar algo? /n*4* - O que eu faço quando chegar no endereço? /n*5* - Redes sociais /n*6* - Outra pergunta";
						enviar_mensagem($phone, $message);
					}
					break;
				case 27:
					if ($body == "1") {
						salva_historico($phone, '', '', 'texto enviado informaçoes', '029');
						$message = "Amorim Business é uma empresa de assessoria. A atividade consiste na pesquisa e fornecimento de dados e informações sobre um assunto de interesse para quem solicitou o serviço. Damos assessoria a para a Produtora ÁZ com diversos serviços como scouting, popularmente conhecido como 'caça-talentos' que busca perfis com talento em potecial para vagas especificas" ;
						enviar_mensagem($phone, $message);
					}if ($body == "2") {
						salva_historico($phone, '', '', 'texto enviado informaçoes', '030');
						$message = "*O que você precisa fazer?* /n*1*- Cancelar /n*2*- Reagendar" ;
						enviar_mensagem($phone, $message);
					}if ($body == "3") {
						salva_historico($phone, '', '', 'texto enviado informaçoes', '031');
						$message = "Não, só o talendo já é mais que mais o suficiente." ;
						enviar_mensagem($phone, $message);
					}if ($body == "4") {
						salva_historico($phone, '', '', 'texto enviado informaçoes', '032');
						$message = "A recepção vai te identificar e te direcionar. A portaria fica disponivel até as 18hrs, mas vamos recebe-lo na entrada";
						enviar_mensagem($phone, $message);
					}if ($body == "5") {
						salva_historico($phone, '', '', 'texto enviado informaçoes', '033');
						$message = "Instagram: /n@_amorimbusiness /n@azcriacaoartistica /n/nSite: https://azcriacaoartistica.com.br/";
						enviar_mensagem($phone, $message);
					}if ($body == "6") {
						salva_historico($phone, '', '', 'texto enviado informaçoes', '034');
						$message = "Me fala, qual sa dúvida?";
						enviar_mensagem($phone, $message);
					} else {
						$message = "Você enviou uma opção inválida, tente novamente digitando só a opção. /nExemplo: 1";
						enviar_mensagem($phone, $message);
					}
					break;
				case 30:
					if ($body == "1") {
						salva_historico($phone, '', '', 'texto enviado informaçoes', '035');
						$message = "Cancelado com sucesso" ;
						enviar_mensagem($phone, $message);
					}if ($body == "2") {
						salva_historico($phone, '', '', 'texto enviado data', '014');
						$message = "*Muito bom, *qual dia seria melhor?* /nExemplo: 29/04";
						enviar_mensagem($phone, $message);
						}else {
							$message = "Você enviou uma opção inválida, tente novamente digitando só a opção. /nExemplo: 1";
							enviar_mensagem($phone, $message);
						}
					break;
				case 29:
					if ($body == "2") {
						salva_historico($phone, '', '', 'texto enviado informaçoes', '027');
						$message = "*Sobre o que você quer saber?* /n*1* - O que é Amorim Business? /n*2* - Preciso cancelar/reagendar meu agendamento /n*3* - Preciso levar algo? /n*4* - O que eu faço quando chegar no endereço? /n*5* - Redes sociais /n*6* - Outra pergunta";
						enviar_mensagem($phone, $message);
					} if (strtoupper($body) == "Outras informações") {
						salva_historico($phone, '', '', 'texto enviado informaçoes', '027');
						$message = "*Sobre o que você quer saber?* /n*1* - O que é Amorim Business? /n*2* - Preciso cancelar/reagendar meu agendamento /n*3* - Preciso levar algo? /n*4* - O que eu faço quando chegar no endereço? /n*5* - Redes sociais /n*6* - Outra pergunta";
						enviar_mensagem($phone, $message);
					}
					break;

				case 31:
					if ($body == "2") {
						salva_historico($phone, '', '', 'texto enviado informaçoes', '027');
						$message = "*Sobre o que você quer saber?* /n*1* - O que é Amorim Business? /n*2* - Preciso cancelar/reagendar meu agendamento /n*3* - Preciso levar algo? /n*4* - O que eu faço quando chegar no endereço? /n*5* - Redes sociais /n*6* - Outra pergunta";
						enviar_mensagem($phone, $message);
					} if (strtoupper($body) == "Outras informações") {
						salva_historico($phone, '', '', 'texto enviado informaçoes', '027');
						$message = "*Sobre o que você quer saber?* /n*1* - O que é Amorim Business? /n*2* - Preciso cancelar/reagendar meu agendamento /n*3* - Preciso levar algo? /n*4* - O que eu faço quando chegar no endereço? /n*5* - Redes sociais /n*6* - Outra pergunta";
						enviar_mensagem($phone, $message);
					}
					break;
				case 32:
					if ($body == "2") {
						salva_historico($phone, '', '', 'texto enviado informaçoes', '027');
						$message = "*Sobre o que você quer saber?* /n*1* - O que é Amorim Business? /n*2* - Preciso cancelar/reagendar meu agendamento /n*3* - Preciso levar algo? /n*4* - O que eu faço quando chegar no endereço? /n*5* - Redes sociais /n*6* - Outra pergunta";
						enviar_mensagem($phone, $message);
					} if (strtoupper($body) == "Outras informações") {
						salva_historico($phone, '', '', 'texto enviado informaçoes', '027');
						$message = "*Sobre o que você quer saber?* /n*1* - O que é Amorim Business? /n*2* - Preciso cancelar/reagendar meu agendamento /n*3* - Preciso levar algo? /n*4* - O que eu faço quando chegar no endereço? /n*5* - Redes sociais /n*6* - Outra pergunta";
						enviar_mensagem($phone, $message);
					}
					break;
				case 33:
					if ($body == "2") {
						salva_historico($phone, '', '', 'texto enviado informaçoes', '027');
						$message = "*Sobre o que você quer saber?* /n*1* - O que é Amorim Business? /n*2* - Preciso cancelar/reagendar meu agendamento /n*3* - Preciso levar algo? /n*4* - O que eu faço quando chegar no endereço? /n*5* - Redes sociais /n*6* - Outra pergunta";
						enviar_mensagem($phone, $message);
					} if (strtoupper($body) == "Outras informações") {
						salva_historico($phone, '', '', 'texto enviado informaçoes', '027');
						$message = "*Sobre o que você quer saber?* /n*1* - O que é Amorim Business? /n*2* - Preciso cancelar/reagendar meu agendamento /n*3* - Preciso levar algo? /n*4* - O que eu faço quando chegar no endereço? /n*5* - Redes sociais /n*6* - Outra pergunta";
						enviar_mensagem($phone, $message);
					}
					break;
				case 34:
					salva_historico($phone, '', '', 'texto enviado instagram', '036');
					$message = "Vou passa sua questão para o setor de Atendimento e logo te respondo";
					enviar_mensagem($phone, $message);

					break;
		}

	}else {//SEM CONVERSA
		salva_historico($phone, '', '', 'Mensagem de boas vindas.', '000');
		$message = "Olá, sou a Lua, a assistente virtual da Amorim Business. Para comerçar, me diga no que posso te ajudar hoje? /n*1 - Audição na Produra ÁZ* /n*2- Outras informações*";
		enviar_mensagem($phone, $message);
	}
	
}

