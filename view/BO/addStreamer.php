<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-xs-12">
            <form action="" method="POST">
                <div class="form-group">
                    <label for="streamer_pseudo">Pseudo du streamer</label>
                    <input type="text" class="form-control" id="streamer_pseudo" name="streamer_pseudo" placeholder="Pseudo du streamer">
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="streamer_active" name="streamer_active">
                    <label class="form-check-label" for="streamer_active">Activer le streamer</label>
                </div>
                <button type="submit" class="btn btn-primary">Créer le profil</button>
            </form>
        </div>
    </div>
</div>
<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Pseudo</th>
                    <th scope="col">Actif</th>
                    <th scope="col">Date de création</th>
                    <th scope="col">Dernière modification</th>
                    <th scope="col">Dernière désactivation</th>
                    <th scope="col" colspan="2" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($streamers)) {
                        foreach ($streamers as $key => $streamer) {
                    ?>
                        <form action="" method="POST">
                            <input type="hidden" value="<?php echo $streamer['id_streamer']; ?>" name="id_streamer">
                            <tr class="<?php echo $streamer['active'] == 0 ? 'table-warning' : ''; ?>">
                                <th scope="row"><?php echo $streamer['id_streamer']; ?></th>
                                <td>
                                    <input 
                                        type="text" 
                                        value="<?php echo $streamer['pseudo']; ?>" 
                                        name="pseudo"
                                        class="form-control"
                                    >
                                </td>
                                <td><?php echo $streamer['active']; ?></td>
                                <td><?php echo $streamer['date_creation']; ?></td>
                                <td><?php echo $streamer['date_update']; ?></td>
                                <td><?php echo $streamer['date_delete']; ?></td>
                                
                                    <td>
                                        <button type="submit" class="btn btn-default" name="delete" value="<?php echo $streamer['active'] == 0 ? '1' : '0'; ?>">
                                            <?php echo $streamer['active'] == 0 ? 'Activer' : 'Désactiver'; ?>
                                        </button>
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-default" name="update">
                                            Modifier
                                        </button>
                                    </td>
                                
                            </tr>
                        </form>
                    <?php }
                    } ?>  
                </tbody>
            </table>  
        </div>
    </div>
</div>