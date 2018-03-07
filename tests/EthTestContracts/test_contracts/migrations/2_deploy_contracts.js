var SmartContractTest = artifacts.require("SmartContractTest");

module.exports = function(deployer) {
  deployer.deploy(SmartContractTest);
};
