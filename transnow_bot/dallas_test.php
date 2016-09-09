<?php
$json_data = '{"head":{},"def":[{"text":"среда","pos":"существительное","gen":"ж","anm":"неодуш","tr":[{"text":"environment","pos":"noun","syn":[{"text":"surroundings","pos":"noun"},{"text":"milieu","pos":"noun"}],"mean":[{"text":"окружающая среда"},{"text":"окружение"}],"ex":[{"text":"морская среда","tr":[{"text":"marine environment"}]},{"text":"естественная среда","tr":[{"text":"natural surroundings"}]},{"text":"городская среда","tr":[{"text":"urban milieu"}]}]},{"text":"Wednesday","pos":"noun","syn":[{"text":"wednesday","pos":"noun"}],"ex":[{"text":"черная среда","tr":[{"text":"black wednesday"}]}]},{"text":"medium","pos":"noun","mean":[{"text":"носитель"}],"ex":[{"text":"питательная среда","tr":[{"text":"nutrient medium"}]}]},{"text":"midst","pos":"noun","mean":[{"text":"разгар"}]},{"text":"framework","pos":"noun","mean":[{"text":"основа"}],"ex":[{"text":"среда разработки","tr":[{"text":"development framework"}]}]},{"text":"environs","pos":"noun"}]}]}';

echo sendDetailedOutput($json_data);

echo '<br/><br/>';

echo '<div style="font-family: monospace; white-space:pre;">';
echo htmlspecialchars(var_export($json_data));
echo '</div>';

function sendDetailedOutput($article)
{
    $data = json_decode($article);
    $trans = $data->def[0]->tr[0]->text;
    $pos = $data->def[0]->tr[0]->pos;
    $syn = $data->def[0]->tr[0]->syn[0]->text;
    //Если синонима нет, выводим просто перевод и часть речи
    if (empty($syn)) {
        $result = $trans . ' (' . $pos . ').';
    } else {
        $syn_pos = $data->def[0]->tr[0]->syn[0]->pos;
        $result = $trans . ' (' . $pos . '), synonym - ' . $syn . ' (' . $syn_pos . ').';

    }
    return $result;
}