module.exports = function(deployer) {
  deployer.deploy(artifacts.require("SmartContractTest"));
  deployer.deploy(artifacts.require("SmartContractBytesTest"));
};
