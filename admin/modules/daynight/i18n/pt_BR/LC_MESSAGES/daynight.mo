��    ;      �  O   �        )   	  (   3     \     b     i     q     u     �  *   �  z  �  	   5	     ?	     Q	     j	     �	     �	  #   �	     �	  �   �	     �
     �
     �
     �
  -   �
  ?   �
  >   %  $   d     �  %   �  $   �     �    �           -  {   <  �   �     :     I     `     |          �     �  ?   �       &     (   E     n     �     �     �     �  �   �  w   M     �  �   �  Q   }  %   �  �  �  +   �  0   �     "     .     7  	   ?     I     d  -   q  "  �     �     �  (   �  +     *   G  -   r  8   �  )   �  �     
   �     �     �     �  B   �  W     U   k  )   �     �  /   �  2   .  )   a     �  %   �#     �#  �   �#  �   {$     %%     6%  "   S%     v%     y%      �%  .   �%  F   �%     &  +   >&  +   j&     �&  %   �&  	   �&     �&     �&  �   �&  �   �'  "   8(  �   [(  [   )  3   x)                         *       /   9            2   #   :   8              "      (                3          7           '                           6   +   -       .           !                $   1       	   )   &   ,   
                 0      5      %                       4   ;     - Force Time Condition False Destination  - Force Time Condition True Destination : Add : Edit Actions Add Add Callflow Applications Are you sure you want to delete this flow? By default, the Call Flow Control module will not hook Time Conditions allowing one to associate a call flow toggle feauture code with a time condition since time conditions have their own feature code as of version 2.9. If there is already an associaiton configured (on an upgraded system), this will have no affect for the Time Conditions that are effected. Setting this to true reverts the 2.8 and prior behavior by allowing for the use of a call flow toggle to be associated with a time conditon. This can be useful for two scenarios. First, to override a Time Condition without the automatic resetting that occurs with the built in Time Condition overrides. The second use is the ability to associate a single call flow toggle with multiple time conditions thus creating a <b>master switch</b> that can be used to override several possible call flows through different time conditions. Call Flow Call Flow Control Call Flow Control Module Call Flow Toggle (%s) : %s Call Flow Toggle Associate with Call Flow Toggle Control Call Flow Toggle Feature Code Index Call Flow Toggle: %s (%s) Call Flow manual toggle control - allows for two destinations to be chosen and provides a feature code		that toggles between the two destinations. Current Mode Default Delete Description Description for this Call Flow Toggle Control Destination to use when set to Normal Flow (Green/BLF off) mode Destination to use when set to Override Flow (Red/BLF on) mode ERROR: failed to alter primary keys  Feature Code Forces to Normal Mode (Green/BLF off) Forces to Override Mode (Red/BLF on) Hook Time Conditions Module If a selection is made, this timecondition will be associated with the specified call flow toggle  featurecode. This means that if the Call Flow Feature code is set to override (Red/BLF on) then this time condition will always go to its True destination if the chosen association is to 'Force Time Condition True Destination' and it will always go to its False destination if the association is with the 'Force Time Condition False Destination'. When the associated Call Flow Control Feature code is in its Normal mode (Green/BLF off), then then this Time Condition will operate as normal based on the current time. The Destinations that are part of any Associated Call Flow Control Feature Code will have no affect on where a call will go if passing through this time condition. The only thing that is done when making an association is allowing the override state of a Call Flow Toggle to force this time condition to always follow one of its two destinations when that associated Call Flow Toggle is in its override (Red/BLF on) state. Linked to Time Condition %s - %s List Callflows Message to be played in normal mode (Green/BLF off).<br>To add additional recordings use the "System Recordings" MENU above Message to be played in override mode (Red/BLF on).<br>To add additional recordings use the "System Recordings" MENU to the above No Association Normal (Green/BLF off) Normal Flow (Green/BLF off) OK Optional Password Override (Red/BLF on) Override Flow (Red/BLF on) Please enter a valid numeric password, only numbers are allowed Please set the Current Mode Please set the Normal Flow destination Please set the Override Flow destination Recording for Normal Mode Recording for Override Mode Reset State Submit There are a total of %s Feature code objects, %s, each can control a call flow and be toggled using the call flow toggle feature code plus the index. This will change the current state for this Call Flow Toggle Control, or set the initial state when creating a new one. Time Condition Reference You can optionally include a password to authenticate before toggling the call flow. If left blank anyone can use the feature code and it will be un-protected You have reached the maximum limit for flow controls. Delete one to add a new one changing primary keys to all fields.. Project-Id-Version: PACKAGE VERSION
Report-Msgid-Bugs-To: 
POT-Creation-Date: 2017-05-02 12:15-0400
PO-Revision-Date: 2017-03-08 21:25+0200
Last-Translator: Kingvoice <suporte@kingvoice.com.br>
Language-Team: Portuguese (Brazil) <http://weblate.freepbx.org/projects/freepbx/daynight/pt_BR/>
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
Language: pt_BR
Plural-Forms: nplurals=2; plural=n != 1;
X-Generator: Weblate 2.4
  - Força Condição Horária Falso Destino  - Força Condição Horária Verdadeiro Destino : Adicionar : Editar Ações Adicionar Adicionar Fluxo de Chamada Aplicações Tem certeza de que deseja excluir esse fluxo? Por padrão, o módulo de Controle de Fluxo de Chamadas não ganhará Condições de Tempo permitindo associar um código de recurso de fluxo de chamada com uma condição de tempo, uma vez que as condições de tempo têm seu próprio código de recurso a partir da versão 2.9. Se já houver uma associação configurada (em um sistema atualizado), isso não afetará as Condições de Tempo que são efetuadas. Definir isto como verdadeiro reverte o comportamento 2.8 e anterior, permitindo que o uso de um alternador de fluxo de chamada seja associado a uma condição de tempo. Isso pode ser útil para dois cenários. Primeiro, para substituir uma Condição de Tempo sem a reinicialização automática que ocorre com as substituições de Condição de Tempo incorporadas. O segundo uso é a capacidade de associar uma única alternância de fluxo de chamada com várias condições de tempo, criando assim uma <b> troca mestre </b> que pode ser usado para substituir vários fluxos de chamadas possíveis através de diferentes condições de tempo. Fluxo de Chamadas Controle de Fluxo de Chamadas Módulo de Controle de Fluxo de Chamadas Alternância de Fluxo de Chamadas (%s) : %s Alternância de fluxo de chamada associado Alternância de Controle de Fluxo de Chamadas Índice de Alternância de Controle de Fluxo de Chamadas Alternância de Fluxo de Chamada: %s (%s) Controle manual de alternância de Fluxo de Chamada - permite que dois destinos sejam escolhidos e fornece um código de recurso 		que alterna entre os dois destinos. Modo Atual Padrão Apagar Descrição Descrição para este Controle de Alternância de Fluxo de Chamada Destino a ser utilizado quando definido como Modo de Fluxo normal (Verde/BLF desligado) Destino a ser usado quando definido como Modo Substituir Fluxo (Vermelho/BLF ativado) ERRO: falha ao alterar chaves primárias  Código de Recurso Força para o Modo Normal (Verde/BLF desligado) Força para Modo Substituir (Vermelho/BLF ativado) Módulo de Condições de Tempo de Gancho Se uma seleção é feita, esta condição horária irá ser associada com o código de recurso de alternar o fluxo da chamada especificado. Isto significa que se o Código de Recurso de Fluxo de Chamada é configurado para substituir (Vermelho/BFL ligado) então esta condição horária irá sempre ir para este destino verdadeiro se a escolha é 'Forçar Condição Horária a Destino Verdadeiro' e irá sempre ir para um destino falso se a escolha é 'Forçar Condição Horária a Destino Falso'. Quando o Código de Recurso de Fluxo de Chamada associado está no modo Normal (Verde/BLF ligado), então esta Condição Horária não irá ter nenhum efeito sobre onde uma chamada irá passar se passar através desta condição horária. A única mudança que ocorre quando uma associação é feita é permitir sobrepor o estado de um Alternador de Fluxo de Chamada para forçar esta condição horária a sempre seguir um dos dois destinos quando este Alternador de Fluxo de Chamadas associado está em estado de sobreposição (Vermelho/BLF ligado). Ligado à Condição Horária %s - %s Lista Fluxo de Chamadas Mensagem a ser reproduzida no modo normal (Verde/BLF desligado). Para adicionar gravações adicionais use o menu "Gravações do Sistema" acima Mensagem a ser reproduzida no modo de substituição (Vermelho/BLF ativado). Para adicionar gravações adicionais, use o menu "Gravações do Sistema" para o item acima Sem Associação Normal (Verde/BLF desligado) Fluxo Normal (Verde/BLF desligado) OK Senha Opcional Substituir (Vermelho/BLF ligado) Fluxo de Substituição (Vermelho/BLF ativado) Introduza uma senha numérica válida, apenas são permitidos números Por favor, defina o Modo Atual Por Favor, defina o destino do Fluxo Normal Defina o destino do Fluxo de Substituição Gravação para o Modo Normal Gravação para o Modo Substituição Reiniciar Estado Enviar Há um total de %s Objetos de Código de Recurso, %s, cada um pode controlar um fluxo de chamada e ser alternado usando o código de recurso de alternância de fluxo de chamada mais o índice. Isso alterará o estado atual para este controle de alternância de fluxo de chamada ou definirá o estado inicial ao criar um novo. Referência de Condição Horária Você pode opcionalmente incluir uma senha para autenticar antes de alternar o fluxo de chamadas. Se deixado em branco qualquer pessoa pode usar o código de recurso e ele estará desprotegido Você atingiu o limite máximo para controles de fluxo. Exclua algum para adicionar um novo alterando chaves primárias para todos os campos... 