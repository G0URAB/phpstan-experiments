<?php

namespace Gourab\PHPStan\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Scalar\String_;
use PHPStan\Rules\Rule;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\ShouldNotHappenException;
use PHPStan\Type\VerbosityLevel;

final class NoMagicLiteralAllowedRule implements Rule
{

    private const MAGIC_LITERAL_TYPE = [
        String_::class, LNumber::class
    ];

    public function getNodeType(): string
    {
        return BinaryOp::class;
    }

    /**
     * @throws ShouldNotHappenException
     */
    public function processNode(Node $node, Scope $scope): array
    {

        $rightOperand = $node->right;
        $leftOperand = $node->left;

        $rightOperandType = $scope->getType($rightOperand);
        $leftOperandType = $scope->getType($leftOperand);

        $rightOperandValue = $rightOperandType->describe(VerbosityLevel::value());
        $leftOperandValue =  $leftOperandType->describe(VerbosityLevel::value());

        if (
            ($this->isOperandMagicLiteral($rightOperand) || $this->isOperandMagicLiteral($leftOperand)) &&
            ($this->operandValueIsNotZero($rightOperandValue) && $this->operandValueIsNotZero($leftOperandValue))
        ) {
            return [
                RuleErrorBuilder::message(
                    'Magic literal found, please define it in a class constant!'
                )->build(),
            ];
        }

        return [];
    }

    private function isOperandMagicLiteral(Expr $operandNode): bool
    {
        return in_array(get_class($operandNode), self::MAGIC_LITERAL_TYPE);
    }

    /* We need to exclude cases for empty items check e.g. count($items) > 0 */
    private function operandValueIsNotZero(string $operandValue):bool
    {
        return false === (is_numeric($operandValue) && intval($operandValue) === 0);
    }
}