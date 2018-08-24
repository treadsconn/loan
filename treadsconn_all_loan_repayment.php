	<?php 
		
	 include "includes/header4.php";

	?>
	
	<div class="gtco-section">
		

			<div class="row">

				<div class="gtco-container">

					<div class="col-md-3 col-sm-3">
						<div class="right-menu">

							<div class="balanceLoan">
								<?php 
									$result= mysqli_query($conn, "SELECT SUM(amount) AS totalsum FROM deposits WHERE acc_no = '".$_SESSION['acc_no']."'");

									$row = mysqli_fetch_assoc($result); 

									$sum = $row['totalsum'];

									$result2 = mysqli_query($conn, "SELECT SUM(amount) AS totalsum2 FROM withdrawals WHERE acc_no = '".$_SESSION['acc_no']."'");

									$row = mysqli_fetch_assoc($result2); 

									$sum2 = $row['totalsum2'];
									
									$available = ($sum - $sum2) - 10;

									$ledger = ($sum - $sum2);

								?>
								<div class="acc_balance">
									<article>Account Balance</article>
									<hr>
									<article class="acc_monies">GHS <?php echo $ledger; ?></article>
								</div>
							</div>

							<hr>

							<div class="">
								<?php 
									//select all info from db
									$querySXW = mysqli_query($conn, "SELECT * FROM loan WHERE acc_no = '".$_SESSION['acc_no']."'");
	                        		$rows = mysqli_fetch_array($querySXW);
								?>
								<article class="debtors">Loan Details</article>
								<div class="specifications">
									<article>
										<table border="1" width="100">
											<thead>
												<tr>
													<th>Item</th>
													<th>Desc</th>
												</tr>
											</thead>
											
											<tbody>
					                          	<tr>
					                            	<td>Acc. Name</td>
					                            	<td><?php echo $rows['acc_name']; ?></td>
					                          	</tr>

					                          	<tr>
					                            	<td>Date Applied</td>
					                            	<td><?php echo $rows['date_applied']; ?></td>
					                          	</tr>
					                          	<tr>
					                            	<td>Acc. No.</td>
					                            	<td><?php echo $rows['acc_no']; ?></td>
					                          	</tr>

					                          	<?php 
							                    	$resultDue = mysqli_query($conn, "SELECT SUM(requested_amount) AS totaLoan FROM loan WHERE acc_no = '".$_SESSION['acc_no']."'");

													$row = mysqli_fetch_assoc($resultDue); 

													$sumRQAmt = $row['totaLoan'];
							                    ?>

					                          	<tr>
					                            	<td>Total Loan Amount</td>
					                            	<td><?php echo ($sumRQAmt) ?></td>
					                          	</tr>

					                          	<tr>
					                            	<td>Interest Rate</td>
					                            	<td><?php echo $rows['loan_rate']; ?>%</td>
					                          	</tr>

					                          	<?php 
							                    	$resultDue = mysqli_query($conn, "SELECT SUM(interest_amount) AS totaLoan FROM loan WHERE acc_no = '".$_SESSION['acc_no']."'");

													$row = mysqli_fetch_assoc($resultDue); 

													$sumIntAmt = $row['totaLoan'];
							                    ?>

					                          	<tr>
					                            	<td>Total Interest Amount</td>
					                            	<td><?php echo ($sumIntAmt) ?></td>
					                          	</tr>

					                          	<?php 
							                    	$resultDue = mysqli_query($conn, "SELECT SUM(total_amount) AS totaLoan FROM loan WHERE acc_no = '".$_SESSION['acc_no']."'");

													$row = mysqli_fetch_assoc($resultDue); 

													$sumLoan = $row['totaLoan'];
							                    ?>

					                          	<tr>
					                            	<td>Total Due Amount</td>
					                            	<td><?php echo ($sumLoan)  ?></td>
					                          	</tr>

					                          	<tr>
					                            	<td>Due Date</td>
					                            	<td><?php echo $rows['repayment_date']; ?></td>
					                          	</tr>
						                    </tbody>
										</table>
									</article>
								</div>
							</div>

							<hr>

							<div class="">
								<article class="debtors">repayment Details</article>
								<div class="specifications">
									<article>
										<table border="1" width="100">
											<tbody>
						                        <tr>
						                          <th>Date</th>
						                          <th>Amount</th>
						                        </tr>
						                      <?php 
						                        $query = mysqli_query($conn, "SELECT * FROM repayment WHERE acc_no = '".$_SESSION['acc_no']."'");
						                        while ($rows = mysqli_fetch_assoc($query)) {
						                      ?>
						                          <tr>
						                            <td><?php echo $rows['trans_date']; ?></td>
						                            <td class="text-center"><?php echo $rows['repaid_amount']; ?></td>
						                          </tr>
						                    </tbody>
						                    
						                    <?php } ?>

						                    <?php 
						                    	$resultT = mysqli_query($conn, "SELECT SUM(repaid_amount) AS totalsum FROM repayment WHERE acc_no = '".$_SESSION['acc_no']."'");

												$row = mysqli_fetch_assoc($resultT); 

												$sumRP = $row['totalsum'];
						                    ?>

						                    <tr>
						                    	<td colspan="1" class="maxvalue">Total</td>
						                    	<td colspan="1" class="maxvalue"><article class="sumExp"><?php echo ($sumRP) ?></article></td>
						                    </tr>
										</table>
									</article>
								</div>
							</div>

							<hr>

							<div class="">
								<article class="debtors">current loan debt</article>
								<div class="specifications">
									<article>
										<table border="1" width="100%">
											<tbody>
												<thead>
													<tr>
														<th colspan="2">amount</th>
													</tr>
												</thead>

												<tbody>
													<tr>
														<td colspan="2" class="text-center"> <?php echo (($sumLoan) - ($sumRP)) ?> </td>
													</tr>
												</tbody>
											</tbody>
										</table>
										<?php 
											
										?>
									</article>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-6 col-sm-6">
						<?php 
							//select all info from db
							$query = mysqli_query($conn, "SELECT * FROM customer WHERE acc_no = '".$_SESSION['acc_no']."'");
                    		$row    = mysqli_fetch_array($query);
						?>
						<div class="topTitle">
							<article>
								<p><a href="">Dashboard</a>  | <a href="treadsconn_all_loan_repayment.php">Repay Loan</a> | <span class=""><?php echo $row['acc_name'] ?></span></p>
							</article>
						</div>
						<?php 
							if(isset($_POST['repay'])){
								//process the inserted acc. number
								$repaid_amount = mysqli_real_escape_string($conn, $_POST['repaid_amount']);
								$description = mysqli_real_escape_string($conn, $_POST['description']);
								//check if there is an empty field
								if(empty($repaid_amount) || empty($description)){
									$fmsg = "All fields are required";
								}

								//check if email is already in the database
								$check="SELECT * FROM loan WHERE acc_no = '".$_SESSION['acc_no']."'";
								$rs = mysqli_query($conn,$check);
								$data = mysqli_fetch_array($rs, MYSQLI_NUM);
								if(!$data[0]) {
							    $fmsg = "Customer has no loan debt to be repaid.";
								}else if($repaid_amount >= $ledger){
										//raise the red alert
										$fmsg = "Insufficient funds, top up more to repay your debt!";
									}else{
										$queryInsert2 = "INSERT INTO repayment (id, acc_no, repaid_amount, description, trans_date) VALUES(NULL, '".$_SESSION['acc_no']."', '$repaid_amount', '$description', NOW())";
		                                $val = mysqli_query($conn, $queryInsert2);

		                                $queryInsert = "INSERT INTO withdrawals (id, acc_no, amount, description, username, trans_date) VALUES(NULL, '".$_SESSION['acc_no']."', '$repaid_amount', '$description', '".$_SESSION['username']."', NOW())";
		                                    $val = mysqli_query($conn, $queryInsert);

		                                if($val){
		                                	//$smsg = "Thank You! Your repayment of GHS <b>$repaid_amount</b> was successful.";
		                                	//gather all required info
		                                	$resultT = mysqli_query($conn, "SELECT SUM(repaid_amount) AS totalsum FROM repayment WHERE acc_no = '".$_SESSION['acc_no']."'");

											$row = mysqli_fetch_assoc($resultT); 

											$sumRP = $row['totalsum'];
											//gather info from total loan debt
											$resultDue = mysqli_query($conn, "SELECT SUM(total_amount) AS totaLoan FROM loan WHERE acc_no = '".$_SESSION['acc_no']."'");

											$row = mysqli_fetch_assoc($resultDue); 

											$sumLoan = $row['totaLoan'];

		                                	if(($sumLoan - $sumRP) <= 0){
												//move details of loans to cleared table
												$cleared = mysqli_query($conn, "INSERT INTO clearedloan SELECT * FROM loan WHERE acc_no = '".$_SESSION['acc_no']."'; DELETE FROM loan WHERE acc_no = '".$_SESSION['acc_no']."'");
												?>
								                    <script type="text/javascript">
								                      swal({   title: "Congratulations!",   text: "You have fully settled your loan. Please re-apply for another loan.",   type: "success",   showCancelButton: false,   confirmButtonColor: "#167F39",   confirmButtonText: "Thanks",   closeOnConfirm: false }, function(){
								                        window.open('treadsconn_all_loan_repayment.php', '_self')
								                      });
								                    </script>
							                    <?php
											}else{
												?>
								                    <script type="text/javascript">
								                      swal({   title: "Well Done!",   text: "You still have loan debts to settle.",   type: "warning",   showCancelButton: false,   confirmButtonColor: "#dc143c",   confirmButtonText: "Confirm",   closeOnConfirm: false }, function(){
								                        window.open('treadsconn_all_loan_repayment.php', '_self')
								                      });
								                    </script>
							                    <?php
											}
		                                	echo "<meta http-equiv='refresh' content='4'>";
		                                }else{
		                                	$fmsg = "Ooops! Operation failed.";
		                                	echo "<meta http-equiv='refresh' content='3'>";
		                            }
								}				                     
							}
						?>
						<div class="newCustomer" id="investement_add">
							<?php 
								//select all info from db
								$queryS = mysqli_query($conn, "SELECT * FROM business");
                        		$rows    = mysqli_fetch_array($queryS);
							?>
							<?php 
								//select all info from db
								$query = mysqli_query($conn, "SELECT * FROM customer WHERE acc_no = '".$_SESSION['acc_no']."'");
	                    		$row    = mysqli_fetch_array($query);
							?>
							<form action="" method="POST">
								<fieldset>
									<legend>kindly complete the form below to repay loan</legend>
									<p><center>Hi! You are processing a loan repayment for: <span class="captionRepayment"><?php echo $row['acc_name'] ?></span></center></p>
                        			<?php if (isset($fmsg)) {?><div class="alert alert-danger" role="alert"> <?php echo $fmsg;?> </div><?php }?>
                        			<?php if (isset($smsg)) {?><div class="alert alert-success" role="alert"> <?php echo $smsg;?> </div><?php }?>
                        			<div class="form-group">
										<input type="text" class="form-control" name="repaid_amount" value="<?php if(isset($repay_amount)){ echo $repay_amount;} ?>" placeholder="enter amount to repay" required="required">
									</div>

									<div class="form-group">
										<textarea class="form-control" placeholder="repayment description" name="description" required="required"><?php if(isset($description)){ echo $description;} ?></textarea>
									</div>

									<div class="form-group">
										<p><i>kindly make sure there is enough money (account balance more than the repayment amount) before clicking on the button below. </i></p>
									</div>

									<div class="form-group">
										<button class="btn btn-md btn-success btn-block" name="repay">Repay Loan</button>
									</div>
								</fieldset>
							</form>
						</div>
					</div>

					<div class="col-md-3 col-sm-3">
						<div class="right-menu">
							<div class="listLoanDebtors">
								<article class="debtors">Loan Debtors</article>
								<table border="1" width="100">
									<tbody>
				                        <tr>
				                          <th>Name</th>
				                          <th>Amount</th>
				                        </tr>
				                      <?php 
				                        $query = mysqli_query($conn, "SELECT * FROM loan ORDER BY requested_amount DESC");
				                        while ($rows = mysqli_fetch_assoc($query)) {
				                      ?>
				                          <tr>
				                            <td><?php echo $rows['acc_name']; ?></td>
				                            <td class="text-center"><?php echo $rows['total_amount']; ?></td>
				                          </tr>
				                    </tbody>
				                    
				                    <?php } ?>

				                    <?php 
				                    	$resultT = mysqli_query($conn, "SELECT SUM(total_amount) AS totalsum FROM loan");

										$row = mysqli_fetch_assoc($resultT); 

										$sumLD = $row['totalsum'];
				                    ?>

				                    <tr>
				                    	<td colspan="1" class="maxvalue">Total</td>
				                    	<td colspan="1" class="maxvalue"><article class="sumExp"><?php echo ($sumLD) ?></article></td>
				                    </tr>
								</table>

								<br>

								<article class="debtors">Cleared Loans</article>
								<table border="1" width="100">
									<tbody>
				                        <tr>
				                          <th>Name</th>
				                          <th>Amount</th>
				                        </tr>
					                      <?php 
					                        $query = mysqli_query($conn, "SELECT * FROM clearedloan");
					                        while ($rows = mysqli_fetch_assoc($query)) {
					                      ?>
				                          <tr>
				                            <tr>
					                            <td><?php echo $rows['acc_name']; ?></td>
					                            <td class="text-center"><?php echo $rows['total_amount']; ?></td>
					                          </tr>
				                          </tr>
				                    </tbody>
				                    
				                    <?php } ?>

				                    <?php 
				                    	$resultT = mysqli_query($conn, "SELECT SUM(total_amount) AS totalsum FROM clearedloan");

										$row = mysqli_fetch_assoc($resultT); 

										$sumCL = $row['totalsum'];
				                    ?>

				                    <tr>
				                    	<td colspan="1" class="maxvalue">Total</td>
				                    	<td colspan="1" class="maxvalue"><article class="sumExp"><?php echo $sumCL; ?></article></td>
				                    </tr>
								</table>

								<br>

								<div class="">
									<article class="debtors">repayment History</article>
									<div class="specifications">
										<article>
											<table border="1" width="100">
												<tbody>
							                        <tr>
							                          <th>Date</th>
							                          <th>Amount</th>
							                        </tr>
							                      <?php 
							                        $query = mysqli_query($conn, "SELECT * FROM rep_history WHERE acc_no = '".$_SESSION['acc_no']."'");
							                        while ($rows = mysqli_fetch_assoc($query)) {
							                      ?>
							                          <tr>
							                            <td><?php echo $rows['trans_date']; ?></td>
							                            <td class="text-center"><?php echo $rows['repaid_amount']; ?></td>
							                          </tr>
							                    </tbody>
							                    
							                    <?php } ?>

							                    <?php 
							                    	$resultT = mysqli_query($conn, "SELECT SUM(repaid_amount) AS totalsum FROM rep_history WHERE acc_no = '".$_SESSION['acc_no']."'");

													$row = mysqli_fetch_assoc($resultT); 

													$sumRP = $row['totalsum'];
							                    ?>

							                    <tr>
							                    	<td colspan="1" class="maxvalue">Total</td>
							                    	<td colspan="1" class="maxvalue"><article class="sumExp"><?php echo ($sumRP) ?></article></td>
							                    </tr>
											</table>
										</article>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>

			</div>

	</div>

<?php 
	
 include "includes/footer.php";

?>