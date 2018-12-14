<?php

class SidebarController extends DefaultController
{

    public function showSidebar()
    {

        $conf = DatabaseModel::getConf();
        $streamers = ['Laink', 'Domingo', 'CaMaK', 'Jessaipa', 'Skyyart', 'Lapi', 'Zerator', 'Terracid', 'LeStream'];
        $streamers_favoris = ['Laink', 'Domingo', 'CaMaK', 'Jessaipa', 'Skyyart', 'Lapi', 'Zerator', 'Terracid', 'LeStream'];
        $client_id = $conf['twitch_client_id'];

        $this->sidebar = '
        <div id="sidebar" class="container-fluid">
            <select id="select_streamer" class="selectpicker" data-live-search="true">
                <option selected>Choisissez le streamer pour afficher son planning</option>
        ';

        foreach ($streamers_favoris as $streamer_favori) {
            $this->sidebar .= '<option value="'.$streamer_favori.'">'.$streamer_favori.'</option>';
        }

        $this->sidebar .= '</select>
        <h3 class="text-center">Streamer online</h3>';

        foreach($streamers as $streamer) {
            $url = "https://api.twitch.tv/kraken/streams/$streamer?client_id=$client_id";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
    
            $data = curl_exec($ch);
            curl_close($ch);
            $info_streamer = json_decode($data);
            
            if($info_streamer->stream != null) {
                $this->sidebar .= '
                <a href="'.$info_streamer->stream->channel->url.'" target="_blank" title="'.$info_streamer->stream->channel->display_name.'">
                    <div class="row">
                        <div class="col-md-2">
                            <img src="'.$info_streamer->stream->channel->logo.'" 
                                alt="'.$info_streamer->stream->channel->display_name.'"
                                class="img-responsive"
                                width="100%"
                            />
                        </div>
                        <div class="col-md-8 text-center">'.$info_streamer->stream->game.'
                            <br/>
                            <small class="text-muted">'.$info_streamer->stream->channel->status.'</small>
                        </div>
                        <div class="col-md-2" title="Viewers">'.$info_streamer->stream->viewers.'</div>
                    </div>
                </a>
                <hr/>
            ';
            }
        }

        $this->sidebar .= '</div> ';

        return $this->sidebar;
    }
}