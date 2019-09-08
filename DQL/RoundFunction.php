<?php

namespace Kspitfire\PgSqlRoundFunction\DQL;

use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;

class RoundFunction extends FunctionNode
{
    /**
     * @var mixed
     */
    public $simpleArithmeticExpression;

    /**
     * @var mixed
     */
    public $roundPrecision;

    /**
     * {@inheritdoc}
     */
    public function parse(Parser $parser)
    {
        $lexer = $parser->getLexer();
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->simpleArithmeticExpression = $parser->SimpleArithmeticExpression();

        if (Lexer::T_COMMA === $lexer->lookahead['type']) {
            $parser->match(Lexer::T_COMMA);
            $this->roundPrecision = $parser->ArithmeticExpression();

            if ($this->roundPrecision === null) {
                $this->roundPrecision = 0;
            }
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    /**
     * {@inheritdoc}
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return sprintf(
            'ROUND(%s%s)',
            $sqlWalker->walkSimpleArithmeticExpression($this->simpleArithmeticExpression),
            (null !== $this->roundPrecision) ? ', ' . $sqlWalker->walkStringPrimary($this->roundPrecision) : ''
        );
    }
}