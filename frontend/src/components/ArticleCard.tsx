import { Card, CardContent, Typography } from '@mui/material'
import { useRouter } from 'next/router'

type ArticleCardProps = {
  title: string
  content: string
  url: string
}

const omit = (text: string) => (len: number) => (ellipsis: string) =>
  text.length >= len ? text.slice(0, len - ellipsis.length) + ellipsis : text

const ArticleCard = (props: ArticleCardProps) => {
  const router = useRouter()

  // タイトルクリックでルーティング
  const handleClick = () => {
    router.push(props.url)
  }

  return (
    <Card
      sx={{
        backgroundColor: 'lightblue',
        mb: 4,
        p: 2,
        width: '100%',
        mx: 'auto',
      }}
    >
      <CardContent>
        <Typography
          variant="h6"
          component="div"
          onClick={handleClick}
          sx={{
            mb: 2,
            fontWeight: 'bold',
            cursor: 'pointer',
            color: 'inherit',
            '&:hover': {
              textDecoration: 'underline',
            },
          }}
        >
          {omit(props.title)(45)('...')}
        </Typography>
        <Typography
          sx={{
            fontSize: 14,
          }}
        >
          {props.content}
        </Typography>
      </CardContent>
    </Card>
  )
}

export default ArticleCard
