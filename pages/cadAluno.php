    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Informática</p>
                    <h5 class="font-weight-bolder mb-0">
                      356
                      <span class="text-success text-sm font-weight-bolder">Inscritos</span>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape shadow text-center border-radius-md">
                    <img style="width: 100%" src="../assets/img/icones/cursos/informatica.png" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Enfermagem</p>
                    <h5 class="font-weight-bolder mb-0">
                      259
                      <span class="text-success text-sm font-weight-bolder">Inscritos</span>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape shadow text-center border-radius-md">
                    <img style="width: 100%" src="../assets/img/icones/cursos/enfermagem.png" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Administração</p>
                    <h5 class="font-weight-bolder mb-0">
                      300
                      <span class="text-success text-sm font-weight-bolder">Inscritos</span>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape shadow text-center border-radius-md">
                    <img style="width: 100%" src="../assets/img/icones/cursos/adm.png" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Secretaria Escolar</p>
                    <h5 class="font-weight-bolder mb-0">
                      210
                      <span class="text-success text-sm font-weight-bolder">Inscritos</span>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <img style="width: 100%" src="../assets/img/icones/cursos/secretaria-escolar.png" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Fim Reader -->

      <div class="row mt-4">
        <h4>Inscrever Aluno(a)</h4>
        <hr>
        <div class="col-lg-12 mb-lg-0 mb-4">
         <form method="post" action="">
                        <div class="row">

                                <div class="form-group col-lg-3">
                                <label class="col-lg-1">Curso</label>
                                    <select class="form-control select" name="curso">
                                        
                                    </select>
                                </div>
                                <div class="form-group col-lg-2">
                                <label class="col-lg-1">Ano</label>
                                    <select class="form-control select" name="ano">
                                        <option value="0">2018</option>
                                        <option value="1">2019</option>
                                        <option value="2">2020</option>
                                        <option value="3">2021</option>
                                        <option value="4">2022</option>
                                        <option value="5" selected>2023</option>
                                        <option value="6">2024</option>
                                        <option value="7">2025</option>
                                        <option value="8">2026</option>
                                        <option value="9">2027</option>
                                        <option value="10">2028</option>
                                        <option value="11">2029</option>
                                        <option value="12">2030</option>
                                    </select>
                                </div>
                                <div class="col-lg-7">
                                    <label class="col-lg-1">Nome</label>
                                    <div class="col-lg-11 form-group">
                                        <input name="nome" id="nome" class="form-control" type="text" required="required">
                                    </div>
                                </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-4">
                            <label class="col-lg-12">Escolaridade</label>
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="radio" name="escolaridade" value="esc1" id="public" checked="checked"> <label for="public">Pública</label>
                                </div>
                                <div class="col-lg-6">
                                    <input type="radio" name="escolaridade" value="esc2" id="private"><label for="private">Privada</label>
                                </div>
                            </div>
                          </div>
                          <div class="col-lg-4">
                            <label class="col-lg-12">Proximidade</label>
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="radio" name="proximidade" value="prox1" id="proxsim" > <label for="proxsim">Sim</label>
                                </div>
                                <div class="col-lg-6">
                                    <input type="radio" name="proximidade" value="prox2" id="proxnao" checked="checked"><label for="proxnao">Não</label>
                                </div>
                            </div>
                          </div>
                          <div class="col-lg-4">
                            <label class="col-lg-12">Portador de alguma deficiência</label>
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="radio" name="deficiente" value="defSim" id="defsim" > <label for="proxsim">Sim</label>
                                </div>
                                <div class="col-lg-6">
                                    <input type="radio" name="deficiente" value="defNao" id="defnao" checked="checked"><label for="proxnao">Não</label>
                                </div>
                            </div>
                          </div>
                        </div>
                        <hr>

                        <div class="form-group tabelaresp">
                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-responsive" id="example">
                                <thead>
                                    <tr>
                                        <th class="padrao2">Ano</th>
                                        <th class="padrao2">Por</th>
                                        <th class="padrao2">Int. T</th>
                                        <th class="padrao2">Red</th>
                                        <th class="padrao2">Mat</th>
                                        <th class="padrao2">His</th>
                                        <th class="padrao2">Geo</th>
                                        <th class="padrao2">Ciê</th>
                                        <th class="padrao2">Fís</th>
                                        <th class="padrao2">Qui</th>
                                        <th class="padrao2">Bio</th>
                                        <th class="padrao2">Art</th>
                                        <th class="padrao2">Rel</th>
                                        <th class="padrao2">Ed. F</th>
                                        <th class="padrao2">Ing</th>
                                        <th class="padrao2">Lit</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <tr>
                                        <td>6º</td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano6[]"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano6[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano6[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano6[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano6[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano6[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano6[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano6[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano6[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano6[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano6[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano6[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano6[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano6[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano6[]" class="form-control padrao"></td>

                                    </tr>
                                    <tr>
                                        <td>7º</td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano7[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano7[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano7[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano7[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano7[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano7[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano7[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano7[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano7[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano7[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano7[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano7[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano7[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano7[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano7[]" class="form-control padrao"></td>
                                    </tr>
                                    <tr>
                                        <td>8º</td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano8[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano8[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano8[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano8[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano8[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano8[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano8[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano8[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano8[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano8[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano8[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano8[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano8[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano8[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano8[]" class="form-control padrao"></td>
                                    </tr>
                                    <tr>
                                        <td>9º</td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano9[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano9[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano9[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano9[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano9[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano9[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano9[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano9[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano9[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano9[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano9[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano9[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano9[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" type="text" name="ano9[]" class="form-control padrao"></td>
                                        <td><input class="form-control input-sm padrao" ng-model="numero.valor" onkeyup="somenteNumeros(this);" btype="text" name="ano9[]" class="form-control padrao"></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <button class="btn btn-success" type="submit" name="cad">Inscrever Aluno(a)</button>
                    </form>
        </div>
        
      </div>