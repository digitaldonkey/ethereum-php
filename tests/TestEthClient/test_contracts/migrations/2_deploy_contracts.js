module.exports = function(deployer) {
  deployer.deploy(artifacts.require("SmartContractTest"));
  deployer.deploy(artifacts.require("SmartContractBytesTest"));
  deployer.deploy(artifacts.require("MultiReturner"));
  deployer.deploy(artifacts.require("CallableEvents"));
};
